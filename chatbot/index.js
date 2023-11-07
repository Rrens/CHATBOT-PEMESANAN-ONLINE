const qrcode = require('qrcode-terminal');
const { Client, LocalAuth } = require('whatsapp-web.js');
const { ListFaqHandler } = require('./features/faq');
const {  ListMenuHandler } = require('./features/menu');
const { ListPromoHandler } = require('./features/promo');
const { gambarBagus } = require('./features/gambarBagus');
const { checkNumberHandler } = require('./features/cekNomor');
const { statusUserHandler, changeStatusHandler } = require('./features/user');

const { 
    orderHandler, 
    updateOrderHandler, 
    listOrder, 
    deteleOrderHandler, 
    checkPaymentHandler,
    paymentCheckoutHandler,
    checkOrderStatusHandler,
    trackingOrderHandler
} = require('./features/pesanan');

const client = new Client({
    authStrategy: new LocalAuth()
});

client.on('qr', qr => {
    qrcode.generate(qr, { small: true });

    // console.log(qr);
});

client.on('ready', async msg => {
    console.log('Client is ready!');
    // try {
    //     const nomorPenerima = '6281216913886';
    //     const pesan = 'Testing';
    //     // const chat = await msg.getChat();
    //     console.log(nomorPenerima)
    //     console.log(pesan)
    //     console.log(msg)
        
    // } catch (error) {
    //     console.log(error)
    // }
    // client.sendMessage(nomorPenerima, pesan);
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

     const salamArray = ['hallo', 'halo', 'p', 'hai', 'hi', 'selamat', 'pagi', 'sore', 'malam', 'hay', 'hello', 'greetings'];

    // let isSalam = false;

    // for(let salam of salamArray){
    //     if(text === salam) {
    //         isSalam = true;
    //         break;
    //     }
    // }

    // if(isSalam){
    //     msg.reply(`Terima kasih telah menggunakan Chatbot DEDE SATOE. Silakan pilih kebutuhan Anda:
    // - faq (untuk melihat pertanyaan dan jawaban yang sering ditanyakan) 
    // - promo (untuk melihat promo yang sedang berjalan) 
    // - menu (untuk melihat daftar menu) 
    // - pilih/{nama barang}/{banyak barang} (untuk menambahkan barang ke keranjang) 
    // - status user (untuk melihat status pengguna saat ini) 

    // Contoh penggunaan:
    // - pilih/sambal ijo/10`);
    // }
``
    if (salamArray.some(salam => text === salam)) {
        msg.reply(`Terima kasih telah menggunakan Chatbot DEDE SATOE. Silakan pilih kebutuhan Anda:
- faq (untuk melihat pertanyaan dan jawaban yang sering ditanyakan) 
- promo (untuk melihat promo yang sedang berjalan) 
- menu (untuk melihat daftar menu) 
- pilih/{nama barang}/{banyak barang} (untuk menambahkan barang ke keranjang) 
- status user (untuk melihat status pengguna saat ini) 

Contoh penggunaan:
- pilih/sambal ijo/10`);
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

    if(text == 'cek pesanan'){
        await checkOrderStatusHandler(text, msg)
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

    if(text === 'status user'){
        await statusUserHandler(text, msg);
    }

    if(text === 'rubah status user'){
        await changeStatusHandler(text, msg);
    }

    if(text.includes('tracking/')){
        await trackingOrderHandler(text, msg)
    }

    const regexCheckout = /^bayar\/([\d\sa-zA-Z,.]+)\/(\d{6})$/;
    if(regexCheckout.test(text)){
        await paymentCheckoutHandler(text, msg)
    }

    // const regexBayar = /^bayar\/([a-zA-Z\s]+)\/(\d+)$/;

    // const regexCheckout = /^bayar\/(credit card|bca|permata|bni|bri|mandiri|danamon|other bank|gopay qris|shopeepay qris|other qris|indomaret|alfamart|kredivo|akulaku)\/(\d+)\/([a-zA-Z\s]+)\/(\d{6})$/;

});

client.initialize();
