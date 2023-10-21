const axios = require("axios");
const { checkNumberHandler } = require("./cekNomor");
require('dotenv').config();

const listOrder = async (text, msg) => {
    const chat = await msg.getChat();
    
    try {
        const phone_number = await checkNumberHandler(msg);
        let phoneNumber = phone_number.data;
        // console.log(phoneNumber);
        return chat.sendMessage(await listOrderRequest(msg, phoneNumber));
    } catch (error) {
        console.log(error)
    }
}

const listOrderRequest = async (msg, phoneNumber) => {
    // console.log(msg);
    
    const result = {
        success: false,
        data: null,
        message: ""
    }

    return await axios({
        method: "POST",
        url: `${process.env.BE_HOST}order/list-order`,
        data: {
            customer: phoneNumber
        },
    }).then((response) => {
        console.log(response.data);
    }).catch((error) => {
        console.log(error);
    })
}

const orderHandler = async (text, msg) => {
    const chat = await msg.getChat();
    
    try {
        const phone_number = await checkNumberHandler(msg);
        let phoneNumber = phone_number.data;
        // console.log(phoneNumber);
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

    // console.log(data);
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
        console.log(error);
    })

}

const updateOrderHandler = async (text, msg) => {
    const chat = await msg.getChat();
    
    try {
        const phone_number = await checkNumberHandler(msg);
        let phoneNumber = phone_number.data;
        // console.log(phoneNumber);
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

    // console.log(data);
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
        console.log(error);
    })
}

module.exports = {
    listOrder,
    orderHandler,
    updateOrderHandler
}