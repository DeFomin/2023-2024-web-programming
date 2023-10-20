import webbrowser
import time

webpage_list = [
    "https://moodle.itmo.ru/mod/resource/view.php?id=7020",
    "https://www.example.com",
    "https://www.anotherexample.com"
]

interval = 5

def open_webpages(webpages, interval):
    for webpage in webpages:
        webbrowser.open(webpage)
        time.sleep(interval)

if __name__ == "__main__":
    open_webpages(webpage_list, interval)
