resource "aws_db_subnet_group" "main" {
  name       = "klaks-db-subnet-group"
  subnet_ids = [aws_subnet.private_1.id, aws_subnet.private_2.id]

  tags = {
    Name = "klaks-db-subnet-group"
  }
}

resource "aws_db_instance" "default" {
  allocated_storage       = 20
  db_name                 = "klaks"
  engine                  = "mysql"
  engine_version          = "8.0"
  instance_class          = "db.t3.micro" # Free tier eligible
  username                = "admin"
  password                = var.db_password
  parameter_group_name    = "default.mysql8.0"
  skip_final_snapshot     = true
  vpc_security_group_ids  = [aws_security_group.db_sg.id]
  db_subnet_group_name    = aws_db_subnet_group.main.name
  publicly_accessible     = false

  tags = {
    Name = "klaks-rds"
  }
}
