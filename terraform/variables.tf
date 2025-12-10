variable "aws_region" {
  description = "AWS Region"
  default     = "ap-south-1"
}

variable "domain_name" {
  description = "The domain name for the website (e.g. instructo.co.in)"
  type        = string
}

variable "db_password" {
  description = "Password for the RDS instance"
  type        = string
  sensitive   = true
  default     = "SecureWaitPass123!" # Ideally passed via env var or secrets manager
}
