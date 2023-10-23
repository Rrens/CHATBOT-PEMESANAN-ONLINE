const axios = require("axios");
const { checkNumberHandler } = require("./cekNomor");
require('dotenv').config();

const ListMenuHandler = async (text, msg) => {
    const chat = await msg.getChat();

    await checkNumberHandler(msg);

    try {
        return chat.sendMessage(await ListMenu());
    } catch (error) {
        console.log(error);
    }
}

const ListMenu = async () => {
    const result = {
        success: false,
        dataName: null,
        dataPrice: null,
        dataOnDiscount: false,
        dataStock: null,
        data: null,
        table: "",
        message: ""
    }

    return await axios({
        method: 'GET',
        url: `${process.env.BE_HOST}menu`
    }).then((response) => {
        if(response.status == 200){
            let arrayData = response.data.data;
            result.success = true;
            result.table = "Nama Barang\tHarga\t\tStok\n";
            result.table += "---------------------------------------------\n";
            for (let i = 0; i < arrayData.length; i++) {
                result.table += `${arrayData[i].name}\tRp.${arrayData[i].price}\t${arrayData[i].stock}\n`;
            }
            result.table += "---------------------------------------------";
        }
        // console.log(result.table)
        return result.table
    }).catch((error) => {
        console.log(error.response.data)
    })
}

module.exports = {
    ListMenuHandler
}