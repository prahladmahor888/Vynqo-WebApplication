# Sangfy Incident Response & Security Playbook

This document defines the emergency procedures, secret rotation steps, session revocation, and notification obligations in case of a security event.

---

## 1. Emergency Session Invalidation
If an admin or user account is compromised, immediately revoke all active sessions:

### Option A: Via Artisan Command (Database Session Driver)
```bash
# Clear all active sessions from database
php artisan db:wipe --database=sessions  # Or truncate sessions table
# Or in MySQL:
# TRUNCATE TABLE sessions;
```

### Option B: Rotate Application Encryption Key
Rotating the app key instantly invalidates all cookie-based sessions across all users:
```bash
php artisan key:generate --force
php artisan config:clear
php artisan cache:clear
```

---

## 2. Secrets & Credential Rotation Checklist

1. **Laravel APP_KEY:**
   ```bash
   php artisan key:generate
   ```
2. **Database Credentials:**
   - Change MySQL password in hosting dashboard / server.
   - Update `DB_PASSWORD` in `.env`.
3. **Admin Passwords:**
   - Update admin credentials in `users` table via `bcrypt` hash or reset seeder.
4. **Third-Party APIs (Agora RTC, Firebase, Mail):**
   - Invalidate old App ID / App Certificate in developer consoles.
   - Generate new credentials and update `.env`.

---

## 3. Threat Notification & Compliance (DPDP / GDPR)
- **Breach Assessment:** Determine whether user PII (names, emails, messages) was affected.
- **Reporting Timelines:**
  - Under India DPDP Act / CERT-In: Report critical cybersecurity incidents within 6 hours.
  - Under GDPR (if EU users are involved): Notify supervisory authority within 72 hours.
- **User Disclosure:** Notify affected users via email with clear remediation advice (e.g. password resets).

---

## 4. Emergency Contacts
- **Security Lead:** security@sangfy.prahlix.com
- **Technical Support:** support@sangfy.prahlix.com
- **System Admin Team:** admin@prahlix.com
