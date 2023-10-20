const axios = require("axios");
require('dotenv').config();

// const ListFAQ2 = async (text, msg) => {
//     const chat = await msg.getChat();
//     // console.log(msg)

//     let array_tanya = ['apakah kamu sudah makan?', 'kamu tadi makan apa?']
    
//     let array_jawab = ['sudah', 'ya gatau'];

//     // Inisialisasi variabel untuk hasil gabungan
//     let hasilGabungan = '';

//     // Menggabungkan teks dari kedua array
//     for (let i = 0; i < array_tanya.length; i++) {
//         hasilGabungan += `Q: ${array_tanya[i]}\nA: ${array_jawab[i]}\n\n`;
//     }

//     try {
//         return chat.sendMessage(hasilGabungan);
//     } catch (error) {
//         console.log(error)
//     }
// }

const ListFaqHandler = async(text, msg) => {

    const chat = await msg.getChat();
    // console.log(chat)
    // chat.sendMessage(await ListFAQ);
    
    try {
        return chat.sendMessage(await ListFAQ());
        // console.log(await ListFAQ())
    } catch (error) {
        console.log(error)
    }
}

const ListFAQ = async (text, msg) => {
    const result = {
        success: false,
        dataAsk: null,
        dataAnswer: null,
        data: null,
        message: ""
    }
    // console.log( process.env.BE_HOST + 'faq');

    return await axios({
        method: 'GET',
        url: `${process.env.BE_HOST}faq`,
    }).then((response) => {
        if(response.status == 200){
            // console.log(response.data.data)
            result.success = true;
            let resultCombined = '';
            let arrayData = response.data.data;
            for (let i = 0; i < arrayData.length; i++) {
                if (i === arrayData.length - 1) {
                    resultCombined += `Q: ${response.data.data[i].question}\nA: ${response.data.data[i].answer}\n`;
                }else{
                    resultCombined += `Q: ${response.data.data[i].question}\nA: ${response.data.data[i].answer}\n \n`;
                }
            }
            result.dataAsk = response.data.data[0].question;
            result.dataAnswer = response.data.data[0].answer;
            result.data = resultCombined;
            result.message = "SUCCESS"
        }else{
            result.message = "FAILED RESPONSE";
        }
        return result.data;
    })
    .catch((error) => {
        console.log(error)
    })
}

module.exports = {
    // ListFAQ,
    // ListFAQ2,
    ListFaqHandler
}
