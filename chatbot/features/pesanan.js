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
        console.log(error.response.data.meta.message)
        
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

    return await axios({
        method: "POST",
        url: `${process.env.BE_HOST}order/store-order`,
        data: {
            product: data.product,
            quantity: data.quantity,
            customer: phoneNumber
        },
    }).then((response) => {
        console.log(response.data);
    }).catch((error) => {
        console.log(error.response.data.meta.message)
        
    })

}

const updateOrderHandler = async (text, msg) => {
    const chat = await msg.getChat();
    
    try {
        const phone_number = await checkNumberHandler(msg);
        let phoneNumber = phone_number.data;
        return chat.sendMessage(await updateOrderRequest(msg, phoneNumber));
    } catch (error) {
        console.log(error.response.data)
        
    }
}

const updateOrderRequest = async (msg, phoneNumber) => {
    const body = msg._data.body;
    const cmd = body.split("/");

    const data = {
        product: cmd[1],
        quantity: cmd[2],
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
        console.log(response.data);
    }).catch((error) => {
        console.log(error.response.data.meta.message)
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

    // console.log(cmd);

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
        console.log(error.response.data.meta.message);
    })
}

module.exports = {
    listOrder,
    orderHandler,
    updateOrderHandler,
    deteleOrderHandler
}