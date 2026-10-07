# 🚨 Sangfy Security Incident Response & Breach Playbook (INCIDENT.md)

**Application:** Sangfy (`com.prahlix.sangfy`)  
**Operator:** Prahlix Technologies  
**Primary Security Contact:** `support@prahlix.com`  
**Compliance Standards:** India DPDP Act 2023, GDPR Article 33/34, Google Play Data Safety  

---

## ⚡ 1. Emergency Protocol: Immediate Session & Token Revocation

If unauthorized access or credential compromise is suspected:

### A. Invalidate All Active User & Admin Web Sessions
Run via terminal or deployment console:
```bash
# 1. Clear active database / file-based sessions
php artisan session:clear

# 2. Invalidate framework cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 3. Rotate application encryption key (Invalidates all existing session cookies & encrypted tokens immediately)
php artisan key:generate --force
```

### B. Invalidate Mobile App Tokens & RTC Calling Keys
- **Agora RTC Tokens:** Rotate Primary & Secondary Certificates immediately in the Agora Console.
- **Firebase / Push Tokens:** Revoke Server API Keys in Google Cloud / Firebase Console and regenerate `google-services.json`.

---

## 🔑 2. Secret & Credential Rotation Checklist

In the event of a secret leak or server compromise, rotate in this strict order:

1. **`APP_KEY`**: Run `php artisan key:generate --force` and restart web workers.
2. **Database Credentials (`DB_PASSWORD`)**:
   - Change MySQL / PostgreSQL user password on the database server.
   - Update `.env` and restart PHP-FPM / web server.
3. **Mail Service (`MAIL_PASSWORD` / SendGrid / SMTP)**:
   - Regenerate SMTP API keys in the mail dashboard.
4. **Third-Party Real-Time & Storage Services**:
   - **Agora App ID / App Certificate**
   - **AWS S3 / Cloudflare R2 Access Keys & Secret Keys**
5. **Admin Master Password**:
   - Change admin credentials immediately:
   ```bash
   php artisan tinker --execute="\$u = App\Models\User::first(); \$u->password = Hash::make('NEW_STRONG_PASSWORD_MIN_16_CHARS'); \$u->save();"
   ```

---

## 🛡️ 3. Verification & Forensics Steps

1. **Inspect Blocked Bot & Security Logs:**
   - Review `/admin/traffic` in the Sangfy Admin Panel.
   - Check `blocked_bot_logs` table for SQL injection, honeypot traps, or abnormal IP clusters.
2. **Inspect Web Server Access Logs:**
   - Locate unusual `401`, `403`, or `500` error bursts:
     - Nginx: `/var/log/nginx/access.log`
     - Laravel: `storage/logs/laravel.log`
3. **Verify Git History:**
   - Confirm no production `.env` or sensitive `.key` files were committed.

---

## ⚖️ 4. Breach Notification Obligations & Regulatory Timelines

Under the **Digital Personal Data Protection (DPDP) Act 2023** and **GDPR (Articles 33 & 34)**:

| Authority / Entity | Trigger Condition | Notification Window | Channel |
| :--- | :--- | :--- | :--- |
| **Data Protection Board of India (DPBI) / CERT-In** | Any confirmed personal data breach affecting Indian residents | **Within 6 hours (CERT-In) / Promptly (DPBI)** | [cert-in.org.in](https://www.cert-in.org.in/) / `incident@cert-in.org.in` |
| **EU Supervisory Authorities (GDPR)** | Significant risk to rights & freedoms of EU data subjects | **Within 72 Hours** | Designated Lead DPA Portal |
| **Affected End Users** | High likelihood of harm, identity theft, or data leakage | **Without undue delay** | In-App System Broadcast + Verified Email (`support@prahlix.com`) |

---

## 📞 5. Incident Response Team & Escalation

- **Incident Commander:** Prahlix Technologies Security Lead
- **Security Inquiries Desk:** `support@prahlix.com`
- **Official Security Portal:** [https://sangfy.prahlix.com/security](https://sangfy.prahlix.com/security)
- **Legal Compliance:** [https://sangfy.prahlix.com/privacy-policy](https://sangfy.prahlix.com/privacy-policy)
