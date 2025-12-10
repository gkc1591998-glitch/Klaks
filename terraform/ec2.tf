resource "aws_instance" "web" {
  ami           = "ami-0dee22c13ea7a9a67" # Ubuntu 24.04 LTS
  instance_type = "t3.micro"
  subnet_id     = aws_subnet.public_1.id
  vpc_security_group_ids = [aws_security_group.web_sg.id]
  key_name      = aws_key_pair.kp.key_name
  iam_instance_profile = aws_iam_instance_profile.ec2_profile.name

  tags = {
    Name = "klaks-web-server"
  }

  user_data = templatefile("${path.module}/userdata.sh", {
    domain_name = var.domain_name
    s3_bucket   = aws_s3_bucket.deploy_bucket.id
    db_hostname = aws_db_instance.default.endpoint
    db_username = aws_db_instance.default.username
    db_password = var.db_password
    db_name     = aws_db_instance.default.db_name
  })
}

output "web_public_ip" {
  value = aws_instance.web.public_ip
}
