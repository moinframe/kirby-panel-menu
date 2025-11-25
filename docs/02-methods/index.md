---
title: Methods
description: Overview of all available PanelMenu methods
---

The `PanelMenu` class provides methods grouped into three categories:

**Core Methods** build the basic structure of your menu:
- `site()` — Add the site entry
- `page()` — Add a page link
- `area()` — Add a built-in panel area
- `separator()` — Add a visual divider

**Advanced Methods** let you create custom entries:
- `custom()` — Fully custom menu entry
- `dialog()` — Entry that opens a dialog
- `drawer()` — Entry that opens a drawer
- `createPage()` — Shortcut for "create page" dialogs

**Active State Methods** control menu highlighting:
- `currentCallback()` — Highlight on specific paths
- `currentExcluding()` — Highlight everywhere except specific paths
