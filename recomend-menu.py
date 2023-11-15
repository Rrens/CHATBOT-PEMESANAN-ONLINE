import requests
from collections import defaultdict
from flask import Flask, jsonify, request


# Fungsi untuk mendapatkan data dari API
def get_api_data():
    url = 'http://127.0.0.1:8000/api/sales-data'
    response = requests.get(url)
    
    if response.status_code == 200:
        return response.json()
    else:
        return None

# Fungsi untuk melakukan content-based filtering
def content_based_filtering(api_data):
    customer_products = defaultdict(set)

    for sale in api_data['sales']:
        customer_id = sale['Customer_id']
        product = sale['Product']
        customer_products[customer_id].add(product)

    def recommend_products(customer_id):
        products_purchased = customer_products[customer_id]
        all_products = {sale['Product'] for sale in api_data['sales']}
        recommended_products = all_products - products_purchased
        
        return recommended_products

    return recommend_products

app = Flask(__name__)
@app.route('/api/sales-data', methods=['GET'])

def get_sales_data():
    api_data = get_api_data()
    
    if api_data:
        # Di sini, asumsikan kita mengambil ID customer dari respons API
        customer_id_from_api = api_data['customer_id']

        # Mendapatkan fungsi rekomendasi dari data API
        recommendation_function = content_based_filtering(api_data)

        # Contoh rekomendasi untuk customer ID dari respons API (3 produk direkomendasikan)
        recommendation = recommendation_function(customer_id_from_api)
        recommended_products = list(recommendation)[:3]  # Membatasi output menjadi 3 produk

        response = {
            "meta": {
                "status": "Success",
                "message": "Data Successfully Processed"
            },
            "data": {
                "recommended_products": recommended_products,
                "customer_id": customer_id_from_api
            }
        }

        return jsonify(response), 200
    
    else:
        return jsonify({"meta": {"status": "Error", "message": "Failed to fetch API data"}}), 404

if __name__ == '__main__':
    app.run(debug=True)
