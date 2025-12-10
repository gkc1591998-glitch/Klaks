resource "random_id" "bucket_id" {
  byte_length = 8
}

resource "aws_s3_bucket" "deploy_bucket" {
  bucket = "klaks-deploy-${random_id.bucket_id.hex}"

  tags = {
    Name = "klaks-deploy-bucket"
  }
}

resource "aws_s3_bucket_versioning" "versioning" {
  bucket = aws_s3_bucket.deploy_bucket.id
  versioning_configuration {
    status = "Enabled"
  }
}
