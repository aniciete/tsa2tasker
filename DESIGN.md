---
name: Tasks for Today
description: Modern Productivity & Task Management Design System for CodeIgniter 4
colors:
  primary: "#dd4814"
  primary-hover: "#c23a0b"
  neutral-bg: "#f8fafc"
  surface: "#ffffff"
  surface-subtle: "#f1f5f9"
  border: "#e2e8f0"
  text: "#1e293b"
  text-muted: "#64748b"
  status-pending: "#d97706"
  status-pending-bg: "#fef3c7"
  status-progress: "#2563eb"
  status-progress-bg: "#dbeafe"
  status-done: "#16a34a"
  status-done-bg: "#dcfce7"
  status-danger: "#dc2626"
  status-danger-bg: "#fee2e2"
typography:
  display:
    fontFamily: "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif"
    fontSize: "clamp(1.5rem, 3.5vw, 2.25rem)"
    fontWeight: 700
    lineHeight: 1.2
    letterSpacing: "-0.015em"
  body:
    fontFamily: "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif"
    fontSize: "1rem"
    fontWeight: 400
    lineHeight: 1.5
    letterSpacing: "normal"
  mono:
    fontFamily: "ui-monospace, SFMono-Regular, Menlo, monospace"
    fontSize: "0.875rem"
    fontWeight: 500
rounded:
  sm: "4px"
  md: "6px"
  lg: "8px"
spacing:
  xs: "4px"
  sm: "8px"
  md: "16px"
  lg: "24px"
  xl: "32px"
components:
  button-primary:
    backgroundColor: "{colors.primary}"
    textColor: "#ffffff"
    rounded: "{rounded.md}"
    padding: "8px 16px"
  button-primary-hover:
    backgroundColor: "{colors.primary-hover}"
  card-task:
    backgroundColor: "{colors.surface}"
    rounded: "{rounded.md}"
    padding: "20px 24px"
---

## Overview

Tasks for Today is designed under **Surface Mode: Operate**: a distraction-free, high-throughput task management surface. Visual clarity, readable typography, and accessible status differentiation supersede decorative flourishes.

**The Anti-Side-Tab Rule.** Cards must never use a thick, unilateral colored border (e.g. `border-left: 4px solid ...`) to signal status. Use distinct, high-contrast status pills and subtle border tinting instead.

## Colors

- **Primary (`#dd4814`, Warm Flame)**: Interactive action triggers, active navigation markers, and focus outlines.
- **Neutral Background (`#f8fafc`, Cool Slate Background)**: Soft off-white backdrop that prevents screen glare.
- **Surface (`#ffffff`) & Border (`#e2e8f0`)**: Crisp, balanced container geometry.
- **Status Indicators**:
  - **Pending**: Warm amber (`#d97706` on `#fef3c7`)
  - **In Progress**: Cobalt blue (`#2563eb` on `#dbeafe`)
  - **Completed**: Emerald green (`#16a34a` on `#dcfce7`)
  - **Danger / Delete**: Crimson red (`#dc2626` on `#fee2e2`)

## Typography

- System font stack (`-apple-system, BlinkMacSystemFont, Segoe UI, Roboto`) optimized for rapid text rendering on any client OS.
- Monospace font (`ui-monospace, SFMono-Regular`) for timestamps, task IDs, and deadline countdowns.

## Layout

- Center-column constrained container (`1140px` max width).
- Grid layout with auto-filling columns for task summaries and stacked lists for task detail queues.
- Minimum interactive tap target: `44px`.

## Elevation & Depth

- Restrained elevation: Subtle `box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05)` on task cards.
- Hover lift: Elevation transition to `box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08)`.

## Shapes

- Consistent `6px` rounding for task cards, form controls, and action buttons.
- Accessible focus rings: `2px solid #dd4814` with `2px` offset via `:focus-visible`.

## Components

### Task Cards
- Clean `#ffffff` card container with `1px solid #e2e8f0` border.
- Title in dark slate (`#1e293b`), description in muted text (`#64748b`).
- Dual action group: status changer buttons, edit, and soft-delete archive trigger.

### Filter Toolbar
- Horizontal segmented control for filtering by task state (All, Pending, In Progress, Completed).

## Do's and Don'ts

### Do's
- **Do** use paired text labels and colors on all status badges.
- **Do** maintain visible `:focus-visible` outlines for keyboard users.
- **Do** confirm soft-deletion and provide recovery indicators in the trash view.

### Don'ts
- **Don't** use thick colored unilateral borders (`border-left: 4px solid ...`) on cards.
- **Don't** use `outline: none` on focus states without an accessible replacement.
- **Don't** hide action buttons behind obscure hover menus on touchscreens.
