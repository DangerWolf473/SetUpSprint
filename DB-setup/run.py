import requests
from bs4 import BeautifulSoup
import mysql.connector

# MySQL database connection settings
username = 'root'
password = ''
host = 'localhost'
database = 'setupsprint_ecommerce_website'

# Connect to MySQL database
cnx = mysql.connector.connect(
    user=username,
    password=password,
    host=host,
    database=database
)

cursor = cnx.cursor()

# URL to scrape
url = 'https://www.microcenter.com/search.aspx?Ntt=cpu'

# Send request to URL and get response
response = requests.get(url)

# Parse HTML content using BeautifulSoup
soup = BeautifulSoup(response.content, 'html.parser')

# Find all product elements on the page
products = soup.find_all('div', class_='product')

# Iterate through each product and extract data
for product in products:
    name = product.find('h2', class_='product-name').text.strip()
    price = product.find('span', class_='product-price').text.strip().replace('$', '')

    # Insert data into MySQL database
    cursor.execute("""
        INSERT INTO product (ProductName, Price)
        VALUES (%s, %s)
    """, (name, price))
    cnx.commit()
    print(f"Inserted product: {name}")

# Close MySQL connection
cursor.close()
cnx.close()