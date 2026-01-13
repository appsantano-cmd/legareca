#!/bin/bash

PHP_INI="/Users/vincentiusadhiel/.config/herd-lite/config/php/8.4/php.ini"

echo "Adding PHP settings to: $PHP_INI"

# Backup
cp "$PHP_INI" "$PHP_INI.backup_$(date +%Y%m%d_%H%M%S)"

# Hapus setting lama jika ada
sed -i '' '/^post_max_size/d' "$PHP_INI"
sed -i '' '/^upload_max_filesize/d' "$PHP_INI"
sed -i '' '/^memory_limit/d' "$PHP_INI"
sed -i '' '/^max_execution_time/d' "$PHP_INI"
sed -i '' '/^max_input_time/d' "$PHP_INI"
sed -i '' '/^curl.cainfo/d' "$PHP_INI"
sed -i '' '/^openssl.cafile/d' "$PHP_INI"

# Tambahkan di akhir file
cat >> "$PHP_INI" << 'EOF'

; ============================================
; File Upload Settings (Added for Large Files)
; ============================================
post_max_size = 100M
upload_max_filesize = 100M
memory_limit = 512M
max_execution_time = 300
max_input_time = 300

; SSL Certificate Paths for HTTPS requests
curl.cainfo="/Users/vincentiusadhiel/.config/herd-lite/bin/cacert.pem"
openssl.cafile="/Users/vincentiusadhiel/.config/herd-lite/bin/cacert.pem"
EOF

echo "Settings added successfully!"
echo ""
echo "Verification:"
grep -E "post_max_size|upload_max_filesize" "$PHP_INI"