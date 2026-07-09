# Project Worklog — PasarGuard PHP SDK

## 🔒 پروتکل کار با GitHub (MANDATORY)

**این پروتکل برای تمام agent‌ها (اصلی و sub) الزامی است. هر تغییری در پروژه باید طبق این پروتکل انجام شود.**

### Workflow استاندارد برای هر تغییری در پروژه:

```
1. PULL آخرین نسخه از GitHub (همیشه قبل از شروع کار)
   ↓
2. بررسی فایل‌های فعلی و درک context
   ↓
3. اعمال تغییرات مورد نظر
   ↓
4. تست محلی (در صورت نیاز)
   ↓
5. git add + git commit با پیام واضح
   ↓
6. PUSH به GitHub
   ↓
7. تأیید push موفق بود
```

### ⚠️ قوانین مهم:

1. **هرگز بدون pull اول، تغییری نده** — ممکنه someone else تغییر داده باشه
2. **هرگز تغییری فقط در sandbox نگه دار** — تمام تغییرات باید به GitHub push بشن
3. **اگه pull conflict داد** — تغییرات لوکال رو stash کن، pull بزن، بعد دوباره اعمال کن
4. **Commit message‌ها به انگلیسی و واضح باشن** — `type: description` (مثل `docs: expand README`)
5. **بعد از هر push** — status رو در worklog ثبت کن

### دستورات استاندارد:

```bash
# Pull آخرین نسخه
cd /home/z/my-project/pasarguard-php && \
  GIT_SSH_COMMAND="/home/z/.venv/bin/python3 /home/z/my-project/scripts/git_ssh_wrapper.py" \
  git pull origin main

# Push تغییرات
cd /home/z/my-project/pasarguard-php && \
  git add -A && \
  git commit -m "type: description" && \
  GIT_SSH_COMMAND="/home/z/.venv/bin/python3 /home/z/my-project/scripts/git_ssh_wrapper.py" \
  git push origin main
```

### مسیرهای مهم:

- **ریپازیتوری لوکال:** `/home/z/my-project/pasarguard-php`
- **ریپازیتوری GitHub:** `git@github.com:pooshgan/pasarguard-php.git`
- **کلید SSH:** `/home/z/.ssh/deploy_key`
- **اسکریپت SSH wrapper:** `/home/z/my-project/scripts/git_ssh_wrapper.py` (برای استفاده از paramiko به جای ssh)
- **برنچه اصلی:** `main`

---

## Task History

---
Task ID: setup-1
Agent: main
Task: راه‌اندازی اتصال به GitHub با Deploy Key

Work Log:
- ساخت جفت کلید ED25519 با Python cryptography
- ذخیره کلید خصوصی در `/home/z/.ssh/deploy_key`
- ذخیره کلید عمومی در `/home/z/.ssh/deploy_key.pub`
- تنظیم SSH config برای github.com
- نصب paramiko و dulwich برای SSH transport (به دلیل نبود ssh binary)
- تست اتصال SSH به GitHub — موفق
- Clone ریپازیتوری `pooshgan/pasarguard-php` با استفاده از پروتکل git-upload-pack دستی
- استخراج pack و index-pack با git لوکال
- تنظیم branch main و remote origin

Stage Summary:
- ✅ اتصال به GitHub برقرار شد
- ✅ کلید SSH کار می‌کند (Authentication موفق)
- ✅ ریپازیتوری در `/home/z/my-project/pasarguard-php` کلون شد
- ✅ 3 commit در تاریخچه: `5b28261` (Initial), `28b9840` (LICENSE), `85a991c` (PSR-4 fix)
- ✅ آماده برای کار روی پروژه
- 📦 پروژه PHP SDK برای PasarGuard Panel است (با Composer)

---
Task ID: readme-1
Agent: main
Task: بازنویسی کامل README.md با مثال برای تمام بخش‌های پروژه

Work Log:
- Pull آخرین نسخه از GitHub (`Already up to date` بود)
- ساخت اسکریپت `git_ssh_wrapper.py` برای اتصال git به GitHub از طریق paramiko (به دلیل نبود ssh binary)
- تست SSH wrapper با `git ls-remote` — موفق
- بررسی کامل تمام ۱۵ فایل endpoint + Client.php + PasarGuard.php + Exception + composer.json
- بازنویسی کامل README.md:
  * Table of contents
  * Architecture diagram (ASCII)
  * Documentation برای هر ۱۵ endpoint group با مثال
  * ۵ real-world example (provisioning، cron، Telegram MiniApp، custom Guzzle، per-request headers)
  * Error handling با retry helper
  * Advanced usage (long-running workers، multi-panel، custom subscription path)
  * API reference کامل
  * Badges و visual layout
- git add + commit با پیام واضح
- Push به GitHub (commit 8d8c8f4)

Stage Summary:
- ✅ commit جدید: `8d8c8f4` با عنوان `docs: rewrite README with comprehensive examples for all 15 endpoint groups`
- ✅ Push موفق به main برنچ
- ✅ README از ۶۴ خط به ۱۱۷۵ خط افزایش یافت
- ✅ تمام endpoint‌ها با مثال مستند شدند
- ✅ پروتکل کار با GitHub در worklog ثبت شد برای استفاده future agent‌ها

---
