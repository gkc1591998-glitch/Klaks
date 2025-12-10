output "db_endpoint" {
  value = aws_db_instance.default.endpoint
}

output "s3_bucket_name" {
  value = aws_s3_bucket.deploy_bucket.id
}

