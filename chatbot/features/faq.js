const axios = require("axios");

const ListFAQ = async (text, msg) => {
    const chat = await msg.getChat();
    console.log(msg)

    let array_tanya = ['apakah kamu sudah makan?', 'kamu tadi makan apa?']
    
    let array_jawab = ['sudah', 'ya gatau'];

    // Inisialisasi variabel untuk hasil gabungan
    let hasilGabungan = '';

    // Menggabungkan teks dari kedua array
    for (let i = 0; i < array_tanya.length; i++) {
        hasilGabungan += `Q: ${array_tanya[i]}\nA: ${array_jawab[i]}\n\n`;
    }

    try {
        return chat.sendMessage(hasilGabungan);
    } catch (error) {
        console.log(error)
    }
}

module.exports = {
    ListFAQ
}
