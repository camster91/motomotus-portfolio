# Motomotus Portfolio Plugin

A high-performance portfolio showcase plugin for WordPress that replicates the minimalist aesthetic and smooth interactions of the Motomotus "Work" page.

## Key Features
- **Dynamic Portfolio Grid:** GSAP-powered responsive grid with entrance animations and magnetic hover effects.
- **Hover Video Previews:** Silently plays an MP4 preview when a user mouses over a project thumbnail.
- **Interactive Video Modal:** Opens a cinematic popup for YouTube, Vimeo, or MP4 videos with custom captions.
- **Live Filtering:** Instant, category-based filtering without page reloads.
- **Custom Post Type:** Easy management via the "Motomotus Work" dashboard menu.

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
- **Popup Caption:** Text that appears beneath the video in the modal.
- **Order (Page Attributes):** Assign a number to control sorting (lower numbers appear first).

### 2. Displaying the Grid
Place the following shortcode on any page or post:
`[motomotus_work]`

### 3. Importing Content
If you have the `import_motomotus_data.php` script:
1. Upload it to your WordPress root.
2. Run it via your browser while logged in as an Admin.
3. **Delete the file immediately** after the "Import Complete" message.

## Technical Details
- **Libraries:** Powered by [GSAP 3.12](https://greensock.com/gsap/) for smooth animations.
- **CSS:** Uses standard CSS Grid and Flexbox for maximum performance.
- **Cleanup:** Includes an `uninstall.php` file to cleanly remove all custom data if deleted.

## Developer Notes
- CSS is located in `assets/css/style.css`.
- JS logic is located in `assets/js/main.js`.
- Meta fields are prefixed with `_motomotus_` in the database.
