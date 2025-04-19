import requests
from io import BytesIO
from PIL import Image
import easyocr
import time

# Initialize the reader
reader = easyocr.Reader(['en'], gpu=False)

# CAPTCHA URL
base_url = "https://darkslateblue-goldfish-123037.hostingersite.com/assets/generate_captcha.php"

# Headers to avoid being blocked
headers = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36"
}

# Number of attempts
attempts = 5
success = 0
failure = 0

for attempt in range(1, attempts + 1):
    print(f"\n[*] Attempt number {attempt}")

    try:
        # Request the CAPTCHA image
        response = requests.get(base_url, headers=headers)
        if response.status_code == 200:
            image = Image.open(BytesIO(response.content))
            image.show()  # Show the image so the user can see it

            # Read text using EasyOCR
            result = reader.readtext(response.content, detail=0)

            if result:
                ocr_text = result[0].strip()
            else:
                ocr_text = "[No text detected]"

            print(f"[+] OCR detected text: {ocr_text}")

            # Ask user for the correct CAPTCHA text
            correct_text = input(">> Enter the correct CAPTCHA text as you see it in the opened image: ").strip()

            # Compare the OCR result with the correct text
            if ocr_text.lower() == correct_text.lower():
                print("[✔️] Correct match")
                success += 1
            else:
                print("[X] Incorrect match")
                failure += 1

            time.sleep(2)  # Small delay between attempts

        else:
            print(f"[!] Failed to load image, status code: {response.status_code}")
            failure += 1

    except Exception as e:
        print(f"[!] Error occurred: {e}")
        failure += 1

# Calculate success rate
success_rate = (success / attempts) * 100
failure_rate = (failure / attempts) * 100

print("\n-----------------------------")
print(f"Total attempts: {attempts}")
print(f"Successful matches: {success}")
print(f"Failed matches: {failure}")
print(f"Success rate: {success_rate:.2f}%")
print(f"Failure rate: {failure_rate:.2f}%")
print("-----------------------------")