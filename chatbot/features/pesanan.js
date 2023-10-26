const axios = require("axios");
const { checkNumberHandler } = require("./cekNomor");
const { error } = require("qrcode-terminal");
require('dotenv').config();

const listOrder = async (text, msg) => {
    const chat = await msg.getChat();
    
    try {
        const phone_number = await checkNumberHandler(msg);
        let phoneNumber = phone_number.data;
        return chat.sendMessage(await listOrderRequest(msg, phoneNumber));
    } catch (error) {
        console.log(error)
    }
}

const listOrderRequest = async (msg, phoneNumber) => {
    const result = {
        success: false,
        data: null,
        message: "",
        table: "",
    }

    return await axios({
        method: "POST",
        url: `${process.env.BE_HOST}order/list-order`,
        data: {
            customer: phoneNumber
        },
    }).then((response) => {
        const dataOrder = response.data.data.order;
        console.log(dataOrder);
        
        let total = 0;
        result.success = 'SUCCESS';
        result.table = `ID ORDER : ${dataOrder[0].id_order}\n`
        result.table += "Nama Barang\tHarga\t\tStok\tDiskon\n";
        result.table += "---------------------------------------------------------\n";
        for (let i = 0; i < dataOrder.length; i++) {
            total += parseFloat(dataOrder[i].price)
            if(dataOrder[i].promo[0] == undefined){
                result.table += `${dataOrder[i].menu[0].name}\tRp.${dataOrder[i].menu[0].price}\t${dataOrder[i].quantity}\n`;
            }else{
                result.table += `${dataOrder[i].menu[0].name}\tRp.${dataOrder[i].menu[0].price}\t${dataOrder[i].quantity}\t${dataOrder[i].promo[0].discount}%\n`;
            }
        }
        result.table += "---------------------------------------------------------\n";
        result.table += `TOTAL : Rp.${total}`
        
        return result.table;
    }).catch((error) => {
        console.log(error.response)
        
    })
}

const orderHandler = async (text, msg) => {
    const chat = await msg.getChat();
    
    try {
        const phone_number = await checkNumberHandler(msg);
        let phoneNumber = phone_number.data;
        return chat.sendMessage(await orderRequest(msg, phoneNumber));
    } catch (error) {
        console.log(error)
    }
}

const orderRequest = async (msg, phoneNumber) => {
    const body = msg._data.body;
    const cmd = body.split("/");

    const data = {
        product: cmd[1],
        quantity: cmd[2],
    }

    const result = {
        success: false,
        data: null,
        message: "",
        table: "",
    }

    return await axios({
        method: "POST",
        url: `${process.env.BE_HOST}order/store-order`,
        data: {
            product: data.product,
            quantity: data.quantity,
            customer: phoneNumber
        },
    }).then((response) => {
        console.log(response.data)
        if(response.data.meta.status == 'failed'){
            return response.data.meta.message;
        }else{
            const dataOrder = response.data.data.order;
            // console.log(dataOrder);
            
            let total = 0;
            result.success = 'SUCCESS';
            result.table = `ID ORDER : ${dataOrder[0].id_order}\n`
            result.table += "Nama Barang\tHarga\t\tStok\tDiskon\n";
            result.table += "---------------------------------------------------------\n";
            for (let i = 0; i < dataOrder.length; i++) {
                total += parseFloat(dataOrder[i].price)
                if(dataOrder[i].promo[0] == undefined){
                    result.table += `${dataOrder[i].menu[0].name}\tRp.${dataOrder[i].menu[0].price}\t${dataOrder[i].quantity}\n`;
                }else{
                    result.table += `${dataOrder[i].menu[0].name}\tRp.${dataOrder[i].menu[0].price}\t${dataOrder[i].quantity}\t${dataOrder[i].promo[0].discount}%\n`;
                }
            }
            result.table += "---------------------------------------------------------\n";
            result.table += `TOTAL : Rp.${total}`
            
            return result.table;
        }
    }).catch((error) => {
        console.log(error.response.data)
        
    })

}

const updateOrderHandler = async (text, msg) => {
    const chat = await msg.getChat();
    
    try {
        const phone_number = await checkNumberHandler(msg);
        let phoneNumber = phone_number.data;
        return chat.sendMessage(await updateOrderRequest(msg, phoneNumber));
    } catch (error) {
        console.log(error)
        
    }
}

const updateOrderRequest = async (msg, phoneNumber) => {
    const body = msg._data.body;
    const cmd = body.split("/");

    const data = {
        product: cmd[1],
        quantity: cmd[2],
    }

    const result = {
        success: false,
        data: null,
        message: "",
        table: "",
    }

    return await axios({
        method: "POST",
        url: `${process.env.BE_HOST}order/update-order`,
        data: {
            product: data.product,
            quantity: data.quantity,
            customer: phoneNumber
        },
    }).then((response) => {
        // console.log(response.data.data.order);
        if(response.data.meta.status == 'failed'){
            return response.data.meta.message;
        }else{
            const dataOrder = response.data.data.order;
            // console.log(dataOrder);
            
            let total = 0;
            result.success = 'SUCCESS';
            result.table = `ID ORDER : ${dataOrder[0].id_order}\n`
            result.table += "Nama Barang\tHarga\t\tStok\tDiskon\n";
            result.table += "---------------------------------------------------------\n";
            for (let i = 0; i < dataOrder.length; i++) {
                total += parseFloat(dataOrder[i].price)
                if(dataOrder[i].promo[0] == undefined){
                    result.table += `${dataOrder[i].menu[0].name}\tRp.${dataOrder[i].menu[0].price}\t${dataOrder[i].quantity}\n`;
                }else{
                    result.table += `${dataOrder[i].menu[0].name}\tRp.${dataOrder[i].menu[0].price}\t${dataOrder[i].quantity}\t${dataOrder[i].promo[0].discount}%\n`;
                }
            }
            result.table += "---------------------------------------------------------\n";
            result.table += `TOTAL : Rp.${total}`
            
            return result.table;
        }
    }).catch((error) => {
        console.log(error.response)
    })
}

const deteleOrderHandler = async (text, msg) => {
    const chat = await msg.getChat();
    
    try {
        const phone_number = await checkNumberHandler(msg);
        let phoneNumber = phone_number.data;
        return chat.sendMessage(await deleteOrderRequest(msg, phoneNumber));
    } catch (error) {
        console.log(error)
    }
}

const deleteOrderRequest = async (msg, phoneNumber) => {
    const body = msg._data.body;
    const cmd = body.split("/");
    const product = cmd[1];

    const result = {
        status: false,
        message: "",
        data: "",
    }

    return await axios({
        method: "POST",
        url: `${process.env.BE_HOST}order/delete`,
        data: {
            customer: phoneNumber,
            product: product
        }
    }).then((response) => {
        result.status = "SUCCESS",
        // result.message = 
        result.data = response.data
        console.log(result.data);
    }).catch((error) => {
        console.log(error.response);
    })
}

const checkPaymentHandler = async (text, msg) => {
    const chat = await msg.getChat();
    
    try {
        const phone_number = await checkNumberHandler(msg);
        let phoneNumber = phone_number.data;
        return chat.sendMessage(await checkPaymentRequest(msg, phoneNumber));
    } catch (error) {
        console.log(error)
    }
}

const checkPaymentRequest = async (msg, phoneNumber) => {
    
    const data = {
        phoneNumber: phoneNumber
    }

    const result = {
        success: false,
        data: null,
        message: "",
        table: "",
    }

    return await axios({
        method: 'POST',
        url: `${process.env.BE_HOST}order/checkout`,
        data: {
            customer: data.phoneNumber,
        }
    }).then((response) => {
        
        let data = response.data.data.data;
        console.log(data);
        
        // console.log(data[2])

        // result.success = 'SUCCESS';
        // result.table = 'METODE PEMBAYARAN\n'
        //     result.table += "--------------------------\n";
        //     for (let i = 0; i < data.length; i++) {
        //         result.table += `${data[i]}\n`;
        //     }
        //     result.table += "--------------------------\n";
        //     result.table += "Cara Memilih Metode pembayaran ex: /bayar/bni";
        //     // result.table += "Cara Checkout bayar/{metode pembayaran}/{virtual account}/{Alamat}/{Kode Pos}"

            
        //     return result.table;
    }).catch((error) => {
        console.log(error.response.data)
    })
}

const paymentCheckoutHandler = async (text, msg) => {
     const chat = await msg.getChat();
    
    try {
        const phone_number = await checkNumberHandler(msg);
        let phoneNumber = phone_number.data;
        return chat.sendMessage(await paymentCheckoutRequest(msg, phoneNumber));
    } catch (error) {
        console.log(error)
    }
}

const paymentCheckoutRequest = async (msg, phoneNumber) => {
    const body = msg._data.body;
    const cmd = body.split("/");

    const data = {
        Address: cmd[1],
        zipCode: cmd[2],
        phoneNumber: phoneNumber
    }

    return await axios({
        method: 'POST',
        url: `${process.env.BE_HOST}order/checkout`,
        data: {
            customer: data.phoneNumber,
            address: data.Address,
            zip_code: data.zipCode
        }
    }).then((response) => {
        
        let data = response.data.data;
        console.log(data);
        return `Silahkan Melakukan Pembayaran Melalui link dibawah ini\n${data.link}`
    }).catch((error) => {
        console.log(error.response)
    })
}

module.exports = {
    listOrder,
    orderHandler,
    updateOrderHandler,
    deteleOrderHandler,
    checkPaymentHandler,
    paymentCheckoutHandler
}