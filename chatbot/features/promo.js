const { default: axios } = require("axios");
require('dotenv').config();

const ListPromoHandler = async (text, msg) => {
    const chat = await msg.getChat();

    // let arrayBarang = ['nasi goreng', 'mie goreng'];
    // let arrayPromo = [10, 20];

    // let hasil = '';

    // for (let i = 0; i < arrayBarang.length; i++) {
    //     hasil += `${arrayBarang[i]} diskon ${arrayPromo[i]}%\n`;
        
    // }
    
    try {
        return chat.sendMessage(await listPromoRequest());
    } catch (error) {
        console.log(error);
    }
}

const listPromoRequest = async () => {
    const result = {
        success: false,
        dataPromo: null,
        dataProduct: null,
        dataPriceProduct: null,
        dataDiscount: null,
        data: null,
        message: ""
    }

    return await axios({
        method: 'GET',
        url: `${process.env.BE_HOST}promo`,
    }).then((response) => {
        if(response.status == 200){
            result.success = true;
            let resultCombined = '';
            let arrayData = response.data.data;
            for(let i = 0; i < arrayData.length; i++){
                if(i === arrayData.length - 1) {
                    dataPromo = response.data.data[i]['name'];
                    dataProduct = response.data.data[i].menu[0]['name'];
                    dataPriceProduct = response.data.data[i].menu[0]['price'];
                    dataDiscount = response.data.data[i]['discount'];
                    let dataPriceAfterDiscount = dataPriceProduct * dataDiscount/100;
                    resultCombined += `Promo ${dataPromo} Beli ${dataProduct} harga Rp.${dataPriceProduct} Diskon ${dataDiscount}% Jadi Rp.${dataPriceAfterDiscount}`
                    // console.log(dataPriceProduct, dataDiscount, dataPriceAfterDiscount)
                }
            }
            result.message = 'SUCCESS'
            result.data = resultCombined;
        }
        return result.data;
    }).catch((error) => {
        console.log(error.response.data)
        
    })
}

module.exports = {
    ListPromoHandler
}