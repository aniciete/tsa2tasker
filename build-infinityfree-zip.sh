#!/usr/bin/env bash
set -e

DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
TMP_DIR="/tmp/tsa2-deploy-$$"
OUTPUT_ZIP="$DIR/tsa2-infinityfree.zip"

echo "==> Packaging lean production build for InfinityFree..."
rm -rf "$TMP_DIR" "$OUTPUT_ZIP"
mkdir -p "$TMP_DIR"

# Copy non-hidden source files, excluding development directories and test artifacts
rsync -av \
  --exclude=".*" \
  --exclude="vendor" \
  --exclude="tests" \
  --exclude="build" \
  --exclude="*.zip" \
  --exclude="build-infinityfree-zip.sh" \
  "$DIR/" "$TMP_DIR/" > /dev/null

# Copy essential server configuration files
cp "$DIR/.htaccess" "$TMP_DIR/.htaccess"
[ -f "$DIR/public/.htaccess" ] && cp "$DIR/public/.htaccess" "$TMP_DIR/public/.htaccess"
[ -f "$DIR/public/style.css" ] && cp "$DIR/public/style.css" "$TMP_DIR/style.css"
[ -f "$DIR/public/favicon.ico" ] && cp "$DIR/public/favicon.ico" "$TMP_DIR/favicon.ico"

# Use production InfinityFree environment file if present, else fallback
if [ -f "$DIR/env.infinityfree" ]; then
    cp "$DIR/env.infinityfree" "$TMP_DIR/.env"
    sed -i '' 's/YOUR_VPANEL_PASSWORD/wvzXw3gDNArWw/g' "$TMP_DIR/.env"
elif [ -f "$DIR/env.example" ]; then
    cp "$DIR/env.example" "$TMP_DIR/.env"
elif [ -f "$DIR/.env" ]; then
    cp "$DIR/.env" "$TMP_DIR/.env"
fi

# Ensure writable subdirectories exist
mkdir -p "$TMP_DIR/writable/cache" "$TMP_DIR/writable/logs" "$TMP_DIR/writable/session" "$TMP_DIR/writable/uploads" "$TMP_DIR/writable/debugbar"
for d in cache logs session uploads debugbar; do
    [ ! -f "$TMP_DIR/writable/$d/index.html" ] && [ -f "$DIR/writable/index.html" ] && cp "$DIR/writable/index.html" "$TMP_DIR/writable/$d/index.html"
done

# Install lean production vendor dependencies (excluding phpunit, test tools)
cd "$TMP_DIR"
composer install --no-dev --optimize-autoloader --no-interaction --quiet

# Create deployment archive
zip -r "$OUTPUT_ZIP" . -x "*.DS_Store" > /dev/null
rm -rf "$TMP_DIR"

# Validate package integrity
echo "==> Verifying package contents..."
for req in "public/index.php" ".htaccess" "public/.htaccess" "vendor/autoload.php" ".env" "tasker.sql" "app/Controllers/Tasks.php" "app/Controllers/Auth.php"; do
    if ! unzip -l "$OUTPUT_ZIP" | grep -q "$req"; then
        echo "Error: Required file $req is missing from $OUTPUT_ZIP" >&2
        exit 1
    fi
done

echo "==> Verification passed! All required production files are present."
echo "==> Build successful: $OUTPUT_ZIP"
ls -lh "$OUTPUT_ZIP"
