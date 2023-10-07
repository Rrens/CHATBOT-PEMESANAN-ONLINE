const ListPromo = async (text, msg) => {
    const chat = await msg.getChat();

    let arrayBarang = ['nasi goreng', 'mie goreng'];
    let arrayPromo = [10, 20];

    let hasil = '';

    for (let i = 0; i < arrayBarang.length; i++) {
        hasil += `${arrayBarang[i]} diskon ${arrayPromo[i]}%\n`;
        
    }

    try {
        return chat.sendMessage(hasil);
    } catch (error) {
        console.log(error);
    }
}

module.exports = {
    ListPromo
}