# Bricks Code Box - WordPress Plugin

Ein **WordPress-Plugin** für den **Bricks Builder**, das ein **Code Box**-Element (Snippet-Box) hinzufügt – mit Syntax-Highlighting, Copy-Button, Zeilennummern, Dark/Light-Theme, optionalem Titel/Dateiname und weiteren Komfortfeatures.

**Short English summary**: A WordPress plugin for Bricks Builder that adds a "Code Box" element with syntax highlighting, copy-to-clipboard, line numbers, theming, and more. Ships with optional PUC-based auto-updates from GitHub.

---

## ✨ Features

- **Bricks-Element „Code Box“**
  - Sprache auswählbar (z. B. HTML, CSS, JS, PHP, JSON, YAML, …)
  - **Syntax-Highlighting** (Prism.js)
  - **Copy-to-Clipboard**-Button (mit ARIA-Label & Feedback)
  - **Zeilennummern** (optional)
  - **Dark/Light-Theme** umschaltbar
  - **Titel/Dateiname** (optional) mit Icon
  - **Zeilenumbruch** umschaltbar (Wrap/No-Wrap)
  - **Max-Höhe** mit Scroll (optional)
  - **Kollabierbar** (optional: auf/zu)
- **Saubere Bricks-Integration**
  - Eigene Kategorie „Bricks Code Box“
  - Control-Gruppen für Inhalt, Darstellung, Verhalten
- **Barrierearm**
  - Fokuszustände, Screenreader-Labels, Button-Keyboard-Support
- **Auto-Updates (optional)**
  - via **Plugin Update Checker (PUC)** direkt aus diesem GitHub-Repo

---

## 🔧 Voraussetzungen

- **WordPress** ≥ 6.0 (WordPress-Installation erforderlich)
- **Bricks Builder** ≥ 1.9.x (Bricks Theme oder Plugin)
- **PHP** ≥ 7.4 (empfohlen: 8.1+)

---

## 📦 Installation

### Variante A: ZIP-Datei erstellen und hochladen (empfohlen)
1. **Repository herunterladen:**
   - GitHub: **Code → Download ZIP** (oder Repository klonen)
   - Entpacken Sie die ZIP-Datei lokal
2. **ZIP-Datei für WordPress erstellen:**
   - Navigieren Sie zum entpackten Ordner (sollte `bricks-code-box-main` oder ähnlich heißen)
   - **Wichtig:** Erstellen Sie eine ZIP-Datei aus dem **Inhalt** des Ordners
   - Die ZIP muss beim Entpacken den Ordner `bricks-code-box/` ergeben
   - Struktur sollte sein: `bricks-code-box/bricks-code-box.php`, `bricks-code-box/elements/`, etc.
3. **In WordPress hochladen:**
   - **WordPress Admin** → **Plugins → Installieren → Plugin hochladen**
   - Ihre erstellte ZIP-Datei auswählen und hochladen
4. **Plugin aktivieren:**
   - Plugin aktivieren
   - In **Bricks Builder** das neue "Code Box"-Element verwenden
