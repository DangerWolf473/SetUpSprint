import mysql.connector
import requests
from bs4 import BeautifulSoup
from fake_useragent import UserAgent
import time
import logging

logging.basicConfig(level=logging.INFO)

# Set up the User-Agent rotation
ua = UserAgent()

def scrape_data(url):
    try:
        headers = {'User-Agent': ua.random}
        response = requests.get(url, headers=headers)
        response.raise_for_status()
        soup = BeautifulSoup(response.text, 'html.parser')

        products_list = []

        # Example scraping logic (adjust as per your HTML structure)
        products = soup.find_all('div', class_='product')
        for product in products:
            name = product.find('h2', class_='product-name').text.strip()
            price = float(product.find('span', class_='product-price').text.strip().replace('$', ''))
            products_list.append((name, price))  # Example data structure

        return products_list

    except requests.exceptions.RequestException as e:
        logging.error(f"Request error for {url}: {e}")
        return []

    except Exception as e:
        logging.error(f"Error scraping {url}: {e}")
        return []

def insert_data(products):
    try:
        cnx = mysql.connector.connect(
            host='localhost',
            user='root',
            password='',  # Replace with your MySQL password
            database='setupsprint_ecommerce_website'
        )

        cursor = cnx.cursor()

        for product in products:
            name, price = product
            cursor.execute("""
                INSERT INTO product (ProductName, Price)
                VALUES (%s, %s)
            """, (name, price))
            cnx.commit()
            logging.info(f"Inserted product: {name}")

    except mysql.connector.Error as err:
        logging.error(f"Error with MySQL: {err}")

    finally:
        if 'cursor' in locals():
            cursor.close()
        if 'cnx' in locals():
            cnx.close()

# URLs for different categories
urls = {
    'CPU': 'https://www.daraz.pk/catalog/?q=cpu',
    'GPU': 'https://www.daraz.pk/catalog/?q=graphics+card',
    'RAM': 'https://www.daraz.pk/catalog/?q=ram',
    'Motherboard': 'https://www.daraz.pk/catalog/?q=motherboard',
    'PC Case': 'https://www.daraz.pk/catalog/?q=pc+case',
    'Hard Drive': 'https://www.daraz.pk/catalog/?q=hard+drive',
    'Gaming Mouse': 'https://www.daraz.pk/catalog/?q=gaming+mouse',
    'Gaming Keyboard': 'https://www.daraz.pk/catalog/?q=gaming+keyboard',
    'Gaming Headset': 'https://www.daraz.pk/catalog/?q=gaming+headset',
    'Gaming Mousepad': 'https://www.daraz.pk/catalog/?q=gaming+mousepad',
    'Gaming Monitor': 'https://www.daraz.pk/catalog/?q=gaming+monitor'
}

# Main script execution
try:
    scraped_data = []
    for category, url in urls.items():
        logging.info(f"Scraping {category}: {url}")
        scraped_data.extend(scrape_data(url))
        time.sleep(2)  # Add a delay to avoid overloading the server

    if scraped_data:
        insert_data(scraped_data)
    else:
        logging.info("No data scraped.")

except Exception as e:
    logging.error(f"Error during script execution: {e}")

logging.info("Script execution complete.")