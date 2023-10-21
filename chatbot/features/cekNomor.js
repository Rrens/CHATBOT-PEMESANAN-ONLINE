const axios = require("axios");
require('dotenv').config();

const checkNumberHandler = async (msg) => {
    // const chat = await msg.getChat();
    const message_from = msg._data.from;
    const cmd = message_from.split("@");

    let phoneNumber = cmd[0];

    try {
        return await checkNumberRequest(phoneNumber);
    } catch (error) {
        console.log(error);
    }
}

const checkNumberRequest = async (phoneNumber) => {

    const result = {
        success: false,
        data: null,
        message: "",
    }

    return await axios({
        method: "POST",
        url: `${process.env.BE_HOST}user/check-phone-number`,
        data: {
            phoneNumber: phoneNumber
        },
        Headers: {
            "accept": "application/json",
            "Content-Type": "application/json",
        }
    }).then(async (response) => {
        
        if(response.data.meta.message !== 'Not Found'){
            result.success = true;
            result.message = response.data.meta.message;
            result.data = response.data.data.whatsapp;
            return result;
        }else{
            
            result.success = true;
            result.data = await addPhoneNumber(phoneNumber);
            return result;
        }
    }).catch((error) => {
        console.log(error);
    })
}

const addPhoneNumber = async (phoneNumber) => {
    
    const result = {
        success: false,
        data: null,
        message: "",
    }
    
    return await axios({
        method: "POST",
        url: `${process.env.BE_HOST}user/add-phone-number`,
        data: {
            phoneNumber: phoneNumber
        },
        Headers: {
            "accept": "application/json",
            "Content-Type": "application/json",
        }
    }).then(async (response) => {
        
        // console.log(response.data['meta']);
        result.success = true;
        result.message = response.data.meta.message;
        result.data = phoneNumber;

        return result.data
    }).catch((error) => {
        // console.log(error);
        return error;
    })
}

module.exports = {
    checkNumberHandler
}
