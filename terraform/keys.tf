resource "tls_private_key" "pk" {
  algorithm = "RSA"
  rsa_bits  = 4096
}

resource "aws_key_pair" "kp" {
  key_name   = "klaks-key"       # Name of the key pair in AWS
  public_key = tls_private_key.pk.public_key_openssh
}

resource "local_file" "ssh_key" {
  filename = "${path.module}/klaks-key.pem"
  content  = tls_private_key.pk.private_key_pem
  file_permission = "0400"
}
