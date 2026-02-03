คู่มือสำหรับเพื่อนร่วมทีม (Windows)
A. ติดตั้งโปรแกรมพื้นฐาน
1) Git for Windows

https://git-scm.com/downloads

2) PHP – แนะนำ XAMPP

https://www.apachefriends.org/

ตอนติดตั้ง XAMPP ให้เลือกอย่างน้อย

PHP

MySQL

phpMyAdmin

3) Composer

https://getcomposer.org/download/

B. ทดสอบว่าพร้อมใช้งาน

เปิด PowerShell แล้วรันทีละบรรทัด

git --version
php -v
composer -V


ต้องเห็นเลขเวอร์ชันครบทั้ง 3 ตัว
ถ้าตัวไหนไม่ขึ้น แปลว่าติดตั้งไม่สมบูรณ์ ต้องลงใหม่หรือตั้งค่า PATH

C. ตั้งค่า Git สำหรับ Windows (ทำครั้งเดียว)
git config --global core.autocrlf true

ส่วนที่ 1 – ติดตั้งโปรเจกต์ครั้งแรก
1. Clone โค้ดจาก Git
git clone https://github.com/ชื่อ/create-hub-studio.git
cd create-hub-studio

2. ติดตั้ง Library ของ PHP
composer install


ผลลัพธ์ที่ถูกต้อง

จะมีโฟลเดอร์ใหม่ชื่อ vendor/

ไม่ควรมี error สีแดง

3. สร้างไฟล์ .env

สร้างไฟล์ชื่อ

.env


เอาโค้ด env ที่เจ้าของโปรเจกต์ส่งให้ มาใส่ในไฟล์นี้

แก้ค่า Database ให้ตรงกับเครื่องตัวเอง เช่น

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ชื่อฐานข้อมูลของเพื่อน
DB_USERNAME=root
DB_PASSWORD=

4. สร้างฐานข้อมูล

เปิด XAMPP

กด Start → MySQL

เข้า phpMyAdmin

สร้าง database ชื่อเดียวกับในไฟล์ .env

5. คำสั่งสำหรับ Laravel
php artisan key:generate
php artisan migrate
php artisan serve


ถ้าไม่ขึ้น error
ให้เปิดเว็บที่

http://127.0.0.1:8000

ส่วนที่ 2 – วิธีส่งโค้ดกลับเข้า GitHub (สำหรับเพื่อน)
1. สร้าง branch ของงาน

ห้ามทำงานบน main ตรง ๆ

git checkout -b feature-login


ชื่อ branch ให้ตั้งตามงานจริง เช่น

feature-login

feature-product

fix-register

2. เมื่อเขียนโค้ดเสร็จ
git add .
git commit -m "add login system"
git push origin feature-login

3. เปิด Pull Request

เข้า GitHub

กดปุ่ม
Compare & pull request

เลือกทิศทางให้ถูก

feature-login  →  main


ใส่รายละเอียดงาน แล้วกด Create Pull Request

หลังจากนี้
เจ้าของ repo จะเป็นคนตรวจโค้ดและ Merge เข้า main เอง

ส่วนที่ 3 – เมื่อมีอัปเดตจาก main

ทุกครั้งก่อนเริ่มงานใหม่ให้ดึงโค้ดล่าสุด

git checkout main
git pull
composer install


แล้วค่อยสร้าง branch ใหม่ทำงานต่อ

กฎสำคัญของโปรเจกต์

ห้าม push เข้า main โดยตรง

ต้องทำงานผ่าน branch + Pull Request เท่านั้น

ห้ามอัปโหลดไฟล์

.env

vendor

ทุกคนต้องรัน composer install เอง
