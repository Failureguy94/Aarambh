# 🩸 Life Link — Saving Lives, One Link at a Time

Life Link is a web-based platform that connects **blood donors** with **patients** and **hospitals** in need. It leverages location-based matching, real-time notifications, OAuth-based login, and streamlined UX to ensure fast and secure blood donation coordination.

---

## 🚀 Features

- 🔐 Secure OAuth2 login
- 📍 Location-based donor & hospital matching
- 📦 Real-time inventory updates
- 📣 Urgent notification triggers for emergencies
- 📅 Appointment and request tracking
- 🔔 Firebase-powered alerts
- 📊 Future-ready for organ donor integration

---

## 🧠 Tech Stack

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: Node.js, Express
- **Database**: MongoDB
- **APIs**: Google Maps, Firebase, OAuth2 (JWT)
- **Auth**: OAuth2 Consent with JWT Token Handling

---

## 🔐 OAuth Consent Flow + Express API

```mermaid
sequenceDiagram
    participant User
    participant Frontend
    participant Backend
    participant OAuth2.0
    participant JWT

    User->>Frontend: Visit Website
    Frontend->>Backend: Request Login
    Backend->>OAuth2.0: OAuth Consent Flow
    OAuth2.0-->>Backend: Access Token
    Backend->>JWT: Issue JWT Token
    JWT-->>Frontend: Send Token to Frontend
