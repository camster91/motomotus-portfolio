# Motomotus Portfolio Plugin

A high-performance portfolio showcase plugin for WordPress that replicates the minimalist aesthetic and smooth interactions of the Motomotus "Work" page.

## Key Features
- **Dynamic Portfolio Grid:** GSAP-powered responsive grid with entrance animations and magnetic hover effects.
- **Hover Video Previews:** Silently plays an MP4 preview when a user mouses over a project thumbnail.
- **Interactive Video Modal:** Opens a cinematic popup for YouTube, Vimeo, or MP4 videos with custom captions. Supports various URL formats (shorts, timestamps, etc.).
- **Live Filtering:** Instant, category-based filtering without page reloads.
- **Robust Architecture:** Graceful fallbacks if GSAP is missing, and thorough cleanup on uninstall.

## Installation
1. Zip the `motomotus-portfolio` folder.
2. In WordPress, go to **Plugins > Add New > Upload Plugin**.
3. Select the zip file and click **Install Now**.
4. **Activate** the plugin.

## How to Use
### 1. Adding Work Items
Go to **Motomotus Work > Add New**:
- **Title:** The name of the project (e.g., ADIDAS).
- **Featured Image:** This is your static thumbnail.
- **Agency/Client:** The subtitle displayed in the grid.
- **Hover Video:** URL to a small MP4 file for the hover effect.
- **Main Video:** The full project video URL (Vimeo/YouTube/MP4).
- **Popup Caption:** Text that appears beneath the video in the modal. Supports basic HTML.
- **Order (Page Attributes):** Assign a number to control sorting (lower numbers appear first).

### 2. Displaying the Grid
Place the following shortcode on any page or post:
`[motomotus_work]`

## Technical Details
- **Libraries:** Powered by [GSAP 3.12](https://greensock.com/gsap/) for smooth animations.
- **CSS:** Modern CSS Grid with responsive breakpoints (1, 2, and 3 columns).
- **License:** Released under the MIT License.

## Developer Notes
- CSS is located in `assets/css/style.css`.
- JS logic is located in `assets/js/main.js`.
- Meta fields are prefixed with `_motomotus_` in the database.
