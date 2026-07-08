#!/bin/bash
cd "$(dirname "$0")"

PHP_BIN="/opt/homebrew/bin/php"
if [ ! -x "$PHP_BIN" ]; then
  PHP_BIN="$(command -v php)"
fi

if [ -z "$PHP_BIN" ]; then
  echo "PHP not found. Install with: brew install php"
  exit 1
fi

PORT="${1:-8080}"
echo "Starting site at http://localhost:$PORT"
echo "Press Ctrl+C to stop."
"$PHP_BIN" -S "localhost:$PORT" router.php
