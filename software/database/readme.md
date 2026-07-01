# Database

The Smart Home project uses MariaDB as a centralized state storage shared between:

- Arduino firmware
- PHP backend
- Web Interface
- Telegram Bot

This directory contains the database schema required to deploy the project.

The exported schema intentionally excludes runtime and user-specific data.
