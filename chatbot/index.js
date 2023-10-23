const qrcode = require('qrcode-terminal');
const { Client, LocalAuth } = require('whatsapp-web.js');
const { ListFaqHandler } = require('./features/faq');
const {  ListMenuHandler } = require('./features/menu');
const { ListPromoHandler } = require('./features/promo');
const { gambarBagus } = require('./features/gambarBagus');
const { checkNumberHandler } = require('./features/cekNomor');
const { 
    orderHandler, 
    updateOrderHandler, 
    listOrder, 
    deteleOrderHandler 
} = require('./features/pesanan');



const client = new Client({
    authStrategy: new LocalAuth()
});



client.on('qr', qr => {
    qrcode.generate(qr, { small: true });
});

client.on('ready', () => {
    console.log('Client is ready!');
});

client.on('message', async msg => {

    const text = msg.body.toLowerCase() || '';

    //check status
    if(text === 'cek'){
        await checkNumberHandler(text, msg)
    }
    
    if (text === 'p') {
        msg.reply('Testing');
    }

    if(text === 'berikan gambar terbaik'){
        await gambarBagus(text, msg)
    }

    if(text === 'faq'){
        await ListFaqHandler(text, msg)
    }

    if(text === 'menu'){
        await ListMenuHandler(text, msg)
    }

    if(text === 'promo'){
        await ListPromoHandler(text, msg)
    }

    if(text == 'pesanan'){
        await listOrder(text, msg)
    }

    const regexOrder = /^pilih\/(\w+\s\w+)\/(\d+)$/;

    if(regexOrder.test(text)){
        await orderHandler(text, msg)
    }

    const regexUpdate = /^rubah\/(\w+\s\w+)\/(\d+)$/;

    if(regexUpdate.test(text)){
        await updateOrderHandler(text, msg)
    }

    if(text.includes('hapus/')){
        await deteleOrderHandler(text, msg)
    }

    if(text === 'tracking'){
        // 
    }

    const regexBayar = /^bayar\/([a-zA-Z\s]+)\/(\d+)$/;

    if(text === regexBayar.test(text)){
        // 
    }

    if(text === 'hapus pesanan'){
        // 
    }
});

client.initialize();
