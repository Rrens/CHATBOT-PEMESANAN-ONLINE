const axios = require("axios");
require('dotenv').config();


const StatusUserHandle = async (text, msg) => {
   
    const chat = await msg.getChat();
    console.log(chat);
    
    try {
        return chat.sendMessage(await StatusUserRequest());
        // console.log(await ListFAQ())
    } catch (error) {
        console.log(error)
    }
}

const StatusUserRequest = async (phoneNumber) => {
    const result = {
        success: false,
        dataStatus: null,
        data: null,
        message: ""
    }

    return await axios({
        method: 'POST',
        url: `${process.env.BE_HOST}status-user`,
        data: {
            phone_number: phoneNumber
        },
        headers: {
            "accept": "application/json",
            "Content-Type": "application/json",
        },
    })
}