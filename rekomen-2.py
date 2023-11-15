import requests
from scipy.spatial.distance import cosine
from collections import Counter
from flask import Flask, jsonify, request

app = Flask(__name__)

def get_api_data():
    # url = 'http://127.0.0.1:8000/api/sales-data'
    url = 'http://127.0.0.1:8000/api/sales'
    response = requests.get(url)
    
    if response.status_code == 200:
        return response.json()
    else:
        return None

@app.route('/api/sales', methods=['GET'])

def get_data():
    # order_data = {
    #     'Customer_1': ['Product_1', 'Product_3', 'Product_5'],
    #     'Customer_2': ['Product_1', 'Product_2', 'Product_4', 'Product_6'],
    #     'Customer_3': ['Product_2', 'Product_3', 'Product_4'],
    #     'Customer_4': ['Product_5', 'Product_6', 'Product_7'],
    #     'Customer_5': ['Product_3', 'Product_6', 'Product_8'],
    #     'Customer_6': ['Product_2', 'Product_7', 'Product_9'],
    #     'Customer_7': ['Product_1', 'Product_4', 'Product_8'],
    #     'Customer_8': ['Product_3', 'Product_5'],
    #     'Customer_9': ['Product_1', 'Product_2', 'Product_9'],
    #     'Customer_10': ['Product_4', 'Product_7', 'Product_8'],
    #     'Customer_11': ['Product_1', 'Product_2', 'Product_4', 'Product_5'],
    #     'Customer_12': ['Product_3', 'Product_6', 'Product_7'],
    #     'Customer_13': ['Product_2', 'Product_4', 'Product_5', 'Product_8'],
    #     'Customer_14': ['Product_1', 'Product_3', 'Product_6', 'Product_9'],
    #     'Customer_15': ['Product_1', 'Product_5', 'Product_7'],
    #     'Customer_16': ['Product_2', 'Product_4', 'Product_8']
    # }
    order_data_api = get_api_data()
    order_data = order_data_api['other_customer']
    status = True
    
    if order_data_api['customer_product'] == None:
        status = False
        
    if status:
        new_customer = order_data_api['customer_product']
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
                "recommended_products": recommended_products,
            }
        }
    return jsonify(response), 200

if __name__ == '__main__':
    app.run(debug=True, port=5100)
