# class-webprograming

## ディレクトリ構成
```bash
project-root/
├─ compose.yaml
├─ src/                         # アプリケーションコード
│   └─ index.php
├─ nginx/
│   └─ default.conf
├─ php/
│   ├─ Dockerfile
│   └─ php.ini
└─ mysql/
   ├─ init/
   │   └─ 01-init.sql
   └─ conf.d/
       └─ skip-name-resolve.cnf
```