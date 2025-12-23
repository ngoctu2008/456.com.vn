from playwright.sync_api import sync_playwright
import os

def verify_app():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        # Emulate a mobile device
        device = p.devices['Pixel 5']
        context = browser.new_context(**device)
        page = context.new_page()

        # Path to the local html file
        cwd = os.getcwd()
        file_path = f"file://{cwd}/android_app/app/src/main/assets/index.html"
        print(f"Loading: {file_path}")

        page.goto(file_path)

        # Wait for content to load
        page.wait_for_selector('#tab-month')

        # Screenshot 1: Month View (Initial)
        page.screenshot(path="/home/jules/verification/1_month_view.png")
        print("Captured Month View")

        # Click "Cài đặt" in bottom nav
        # The button has text "Cài đặt"
        settings_btn = page.get_by_role("button", name="Cài đặt")
        settings_btn.click()

        # Wait for settings view to be visible
        # Check if #tab-settings is visible (it has class 'flex' when visible, 'hidden' when not)
        # Note: Playwright's checking of 'visible' handles display:none/hidden classes
        page.wait_for_selector('#tab-settings')

        # Screenshot 2: Settings View
        page.screenshot(path="/home/jules/verification/2_settings_view.png")
        print("Captured Settings View")

        # Click "Tháng" to go back
        month_btn = page.get_by_role("button", name="Tháng")
        month_btn.click()

        # Wait for month view
        page.wait_for_selector('#tab-month')

        # Screenshot 3: Back to Month View
        page.screenshot(path="/home/jules/verification/3_back_to_month.png")
        print("Captured Back to Month View")

        browser.close()

if __name__ == "__main__":
    verify_app()
