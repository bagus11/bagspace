#!/bin/bash

# Meminta pengguna untuk memasukkan token bot Telegram
read -p "Masukkan token bot Telegram Anda: " bot_token

# Memperbarui file .env dengan token yang diberikan
echo "TELEGRAM_BOT_TOKEN=$bot_token" >> .env

echo "Token bot Telegram telah berhasil ditambahkan ke file .env."