# 🌟 LifeAchievements – Felhasználói dokumentáció

## Áttekintés
A **LifeAchievements™** egy játékosított célkövető weboldal, amely lehetővé teszi, hogy kategóriákba rendezett életcélokat, feladatokat és kihívásokat teljesíts.

Minden achievement:
- XP jutalmat ad ⭐
- fejlődést biztosít 📈
- megjelenik a profilodban és statisztikáidban

Az alkalmazás célja:
- Motiváció
- Fejlődés
- Vizuális visszajelzés
- Mindez egy helyen

---

## 🚀 Kezdő lépések

### Főoldal
A főoldal bemutatja az alkalmazás funkcióit és célját.

Innen:
- **GET STARTED**
  - Log In – bejelentkezés
  - Sign Up - regisztráció
- Ezek a felső navigációs menüből is elérhetőek.
- Lejjebb tekerve megtekeinthető az oldal beszámolója.

---

## 🔐 Regisztráció és bejelentkezés

### Regisztráció
1. Sign Up
2. Add meg a kövektező adatokat:
   - felhasználónév
   - e-mail
   - jelszó
3. Create Account

![Sign up](https://cdn.imgchest.com/files/0b43093625c1.png)

✔ Sikeres regisztráció után automatikus bejelentkezés

---

### Bejelentkezés
A bejelentkezéshez:
1. Menj a **Log In** oldalra.
2. Add meg az e-mail címedet és a jelszavadat.
3. Kattints a **Log In** gombra.

![Log in](https://cdn.imgchest.com/files/00e33172b893.png)

Helytelen adatok esetén hibát jelez a rendszer.

### Kijelentkezés
A kijelentkezés a **Profile** oldalon lévő vörös **Log Out** gombbal lehetséges.

---

## 🧭 Navigáció a felületen

A felső navigációs menüben az alábbi elemek érhetők el:

- **LIFE ACHIEVEMENTS** – bal oldalon, visszavisz a főoldalra.
- **Catalog** – kategóriák böngészése.
- **My Achievements** – saját teljesített feladatok ömlesztve.
- **Goals** – Elmentett teljesítmények későbbi teljesítésre
- **Leaderboard** – Többi felhasználó közti ranglista
- **Profile** – profilinformációk megtekintése.

Mobilnézetben lenyíló menüben jelenik meg.

---

## 📚 Katalógus (Catalog)

![Catalog](https://cdn.imgchest.com/files/96309c31267e.png)

### Kategóriák
Minden kategória tartalmaz:
- ikont
- nevet
- szín (dinamikus 🎨)
- kattintható kártyát

---

### Kategória kiválasztása
Egy kategóriára kattintva megjelenik:
- a kategória neve
- hozzá tartozó achievementek listája

![Achievements](https://cdn.imgchest.com/files/2746ad8f2c5a.png)

### Achievement megtekintése
Kattints egy achievement kártyára, hogy megnyíljanak a részletek:
- név
- leírás
- XP jutalom
- kategória ikon

![Achievement](https://cdn.imgchest.com/files/c2859960459c.png)

---

## ✅ Achievement rendszer

### Teljesítés
- **MARK AS COMPLETED**
- siker után:
  - zöld pipa ✔
  - XP jár ⭐
  - bekerül a profilba

![AchievementCompleted](https://cdn.imgchest.com/files/3ab95ac84e79.png)

---

### 🔁 Repeatable achievementek 🆕
- többször teljesíthetők
- számláló növekszik

---

## 🎯 Goals rendszer

Lehetővé teszi: "Mit szeretnék megcsinálni később?"

### Funkciók:
- **Save to Goals** – célokba mentés
- **Remove from Goals** – célokból törlés
- automatikus törlés ha teljesíted

---

### Goals oldal
- csak a mentett achievementek
- kattintás → adott achievement megnyitása

---

## 🏆 Saját achievementek (My Achievements)

![MyAchievements](https://cdn.imgchest.com/files/8036d36699da.png)

Ezen az oldalon:
- listázva láthatók a korábban teljesített achievementek
- kategória ikonokkal együtt jelennek meg
- minden achievement mellett látszik a zöld pipa
- maximum 9 elem jelenik meg egy oldalon
- ha több achievemented van, akkor oldalszámozás jelenik meg


Üres lista esetén a rendszer jelez:
> "You haven’t completed any achievements yet."

---

## 🏅 Badge rendszer

A felhasználó kitűzőket kap:
- achievement teljesítésért
- különleges eseményekért (pl. dark mode 🌙)

Megjelenés:
- popup formában
- vizuális jutalom 🎉

---

## 👥 Barát rendszer (Friends)

### Funkciók:
- barátok listája
- barátkérelem küldés
- kérelem elfogadás / visszavonás

### Panel:
- Bármely oldal jobb alsó sarkából elérhető
- 3 tab:
  - Friends
  - Requests
  - Add

---

### Friends
- profilképek
- kattintás → profil

---

### Requests
- bejövő + kimenő
- Accept / Cancel

✔ üres állapot kezelve:
> "You have no pending requests..."

---

### Add
- felhasználónév alapú keresés
- alul input + gomb
- középen segítő szöveg

---

## 🏆 Ranglista (Leaderboard)

Top felhasználók listája:
- XP alapján rangsorol
- profilképpel
- vizuális rangsor
- Barátaid ranglistájának megjelenítése

---

## 👤 Profil oldal (Profile)

![Profile](https://cdn.imgchest.com/files/0383dc09c99d.png)

### Tartalom
- felhasználónév
- e-mail cím
- profilkép
- bio
- szint és tapasztalati pont csík

A profiloldalon található:
- **Log Out** gomb – amely kijelentkeztet a rendszerből

---

### 📊 Stats
- Achievements
- XP
- Goals
- Kedvenc Kategória

---

## 🌗 Téma váltás (Light / Dark mode)

A logo megnyomására:
- a világos téma **Dark Theme**-re vált
- fekete háttér
- fehér szövegek
- fehér árnyék és glow effekt a kategóriáknél és teljesítményeknél az eddigi fekete helyett
- a felületi elemeknek saját sötét módú stílusuk van

A váltás újra a logóra kattintva visszaáll világos módra.

---

## Hibaüzenetek és visszajelzések

A rendszer az alábbi visszajelzéseket adhatja:

### Regisztráció során
- hiányzó mező
- nem egyező jelszavak
- már használt e-mail cím

### Bejelentkezés során
- hibás jelszó vagy felhasználó
- hiányzó mező

---

## 🧠 Összegzés
A LifeAchievements alkalmazás egyszerű, letisztult és könnyen kezelhető módon segít:
- célokat kitűzni,
- fejlődni,
- visszajelzést kapni,
- rendszerezni a teljesítményeket.

---

## 👨‍💻 Fejlesztők

*A LifeAchievements™ projekt fejlesztői:*
- Szabó András  
- Nagy Bernát  
- Ádám János  
