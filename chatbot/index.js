const qrcode = require('qrcode-terminal');
const { Client, LocalAuth } = require('whatsapp-web.js');
const { ListFAQ, ListFaqHandler } = require('./features/faq');
const { ListMenu } = require('./features/menu');
const { ListPromoHandler } = require('./features/promo');



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
    if (text === 'p') {
        msg.reply('Testing');
    }

    if(text === 'faq'){
        await ListFaqHandler(text, msg)
    }

    if(text === 'berikan gambar terbaik'){
        await ListMenu(text, msg)
    }

    if(text === 'promo'){
        await ListPromoHandler(text, msg)
    }

    if(text === 'list pesanan'){
        // 
    }

    if(text === 'tracking'){
        // 
    }

    if(text === 'bayar'){
        // 
    }
    if(text === 'hapus pesanan'){
        // 
    }
});

client.initialize();
