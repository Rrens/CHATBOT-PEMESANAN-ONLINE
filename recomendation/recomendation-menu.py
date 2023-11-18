import requests
from scipy.spatial.distance import cosine
from collections import Counter
from flask import Flask, jsonify, request
from dotenv import load_dotenv
import os

load_dotenv()

app = Flask(__name__)

def get_data_request():
    if request.method == 'POST':
        data_json = request.json
        try:
            return data_json
        except KeyError as e:
        # Tangkap kesalahan jika kunci tidak ada dalam data
            return {"error": f"KeyError: {str(e)}"}, 400

        except ZeroDivisionError:
            # Tangkap kesalahan jika terjadi pembagian dengan nol
            return {"error": "Cannot divide by zero"}, 400

        except Exception as e:
            # Tangkap kesalahan umum
            return {"error": f"An error occurred: {str(e)}"}, 500
        

@app.route('/cek', methods = ['POST'])

def process_recomendation():
    order_data_api = get_data_request()
    order_data = order_data_api[0]['other_customer']
    # return jsonify(order_data_api)
    status = True
    
    if order_data_api[0]['customer_product'] == None:
        status = False
        
    if status:
        new_customer = order_data_api[0]['customer_product']
    else:
        all_products = [product for products in order_data.values() for product in products]

        # Menghitung produk yang paling sering dibeli
        most_common_products = Counter(all_products).most_common(3)
        # print("Produk yang paling banyak dibeli:")
        array_product = []
        for product, count in most_common_products:
            # print(f"Produk: {product}, Jumlah Pembelian: {count}")
            array_product.append(product)
        new_customer = array_product
    # Mengumpulkan semua produk yang dibeli oleh semua customer

    # Mencari seluruh produk yang ada
    all_products = set()
    for products in order_data.values():
        all_products.update(products)

    # Membuat matriks vektor fitur
    matrix = []
    for customer, products in order_data.items():
        row = []
        for product in all_products:
            if product in products:
                row.append(1)
            else:
                row.append(0)
        matrix.append(row)

    # Matriks untuk customer baru
    row = []
    for product in all_products:
        if product in new_customer:
            row.append(1)
        else:
            row.append(0)
    new_matrix = row

    # Menghitung similarity antara customer baru dan customer lainnya
    similarities = [1 - cosine(new_matrix, matrix[i]) for i in range(len(matrix))]

    # Mencari customer dengan similarity tertinggi
    most_similar_customer_index = similarities.index(max(similarities))

    # Mengumpulkan produk dari customer dengan similarity tertinggi
    similar_products = set(order_data[f'Customer_{most_similar_customer_index + 1}'])
    # similar_products = set(order_data[most_similar_customer_index + 1])

    # Menghitung rekomendasi produk (3 produk)
    recommended_products = similar_products
    recommended_products = list(recommended_products)[:3]
    print(f"Rekomendasi 3 produk untuk customer baru: {recommended_products}")
    response = {
            "meta": {
                "status": "Success",
                "message": "Data Successfully Processed"
            },
            "data": {
                "id_customer": order_data_api[0]['id'],
                # "id_customer": 1,
                "recommended_products": recommended_products,
            }
        }
    
    url = os.getenv("URL_API_POST")
    response_post = requests.post(url, json=response)
    response_post_data = response_post.json()
    return jsonify(response_post_data)
    
if __name__ == '__main__':
    app.run(debug=True, port=5200)
