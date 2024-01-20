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
    trackingOrderHandler,
    checkOrderStatusPerDateHandler
} = require('./features/pesanan');
const { botHandler } = require('./features/Bot');

const client = new Client({
    authStrategy: new LocalAuth()
});

client.on('qr', qr => {
    qrcode.generate(qr, { small: true });

    // console.log(qr);
});

client.on('ready', async msg => {
    console.log('Client is ready!');
    
  // Number where you want to send the message.
    // const number = "+6281216913886";

    // // // Your message.
    // const text = "Hey john";

    // // Getting chatId from the number.
    // // we have to delete "+" from the beginning and add "@c.us" at the end of the number.
    // const chatId = number.substring(1) + "@c.us";

    // // Sending message.
    // client.sendMessage(chatId, text);
    // const number = "+6281216913886";

    // // // Your message.
    // // Your message.
    // const messageText = "Oii";

    // // Getting chatId from the number.
    // // we have to delete "+" from the beginning and add "@c.us" at the end of the number.
    // const chatId = number.substring(1) + "@c.us";

    // // Function to send a message
    // const sendMessage = () => {
    //     client.sendMessage(chatId, messageText);
    // };

    // // Set an interval to send the message every 5 seconds (5000 milliseconds)
    // const intervalId = setInterval(sendMessage, 1000);

    // // Stop the interval after a certain number of iterations (e.g., 20 times)
    // // This prevents the loop from running indefinitely
    // let iterations = 0;
    // const maxIterations = 10;

    // const stopInterval = () => {
    //     clearInterval(intervalId);
    // };

    // // Set a timeout to stop the interval after a certain number of iterations
    // setTimeout(stopInterval, maxIterations * 1000);
});

client.on('message', async msg => {

    const text = msg.body.toLowerCase() || '';

    //  bot/{desimal}/{angka 1-10000}/{angka 1-10}
    const regexBot = /^bot\/\d+\/\d+\/\d+(\/.*)?$/;

    if(regexBot.test(text)){
        const body = msg._data.body;
        const cmd = body.split("/");

        const data = {
            nomor: cmd[1],
            banyak: cmd[2],
            lama: cmd[3],
            pesan: cmd[4],
        }
        console.log(data)

        const number = `+62${data.nomor}`;
        const messageText = `${data.pesan}`;
        const chatId = number.substring(1) + "@c.us";

        let iterations = 0;
        const maxIterations = data.banyak;

        const sendMessage = () => {
            client.sendMessage(chatId, messageText);
            iterations++;

            // Stop the interval after reaching the desired number of iterations
            if (iterations >= maxIterations) {
                clearInterval(intervalId);
            }
        };
        let interval = `${data.lama}000`
        // Set an interval to send the message every 5 seconds (5000 milliseconds)
        const intervalId = setInterval(sendMessage, interval);
    }
    //check status
    if(text === 'cek'){
        await checkNumberHandler(msg)
    }
    
    if (text === 'p') {
        msg.reply('Testing');
    }

    if(text === 'berikan gambar terbaik'){
        await gambarBagus(text, msg)
    }

    const salamArray = ['hallo', 'halo', 'p', 'hai', 'hi', 'selamat', 'pagi', 'sore', 'malam', 'hay', 'hello', 'greetings']

    if (salamArray.some(salam => text === salam)) {
        msg.reply(`Terima kasih telah menggunakan Chatbot DEDE SATOE. Silakan pilih kebutuhan Anda:
- faq (untuk melihat pertanyaan dan jawaban yang sering ditanyakan) 
- promo (untuk melihat promo yang sedang berjalan) 
- menu (untuk melihat daftar menu) 
- pilih/{nama barang}/{banyak barang} (untuk menambahkan barang ke keranjang) 
- status user (untuk melihat status pengguna saat ini) 
- pesanan (untuk melihat keranjang)
- riwayat (melihat semua riwayat pesanan)
- riwayat/{tanggal-bulan-tahun} (melihat riwayat pesanan sesuai tanggal)
- tolong (untuk melihat semua perintah di chatbot)

Contoh penggunaan:
- pilih/sambal ijo/10
- riwayat/12-04-2023
- menu`);
    }

    const helpArray = ['help', 'tolong']
    if (helpArray.some(salam => text === salam)) {
        msg.reply(`Berikut adalah semua list perintah yang dapat dilakukan di Chatbot DEDE SATOE. Silakan pilih kebutuhan Anda:
- faq (untuk melihat pertanyaan dan jawaban yang sering ditanyakan) 
- promo (untuk melihat promo yang sedang berjalan) 
- menu (untuk melihat daftar menu) 
- pilih/{nama barang}/{jumlah barang} (untuk menambahkan barang ke keranjang) 
- rubah/{nama barang}/{jumlah barang} (untuk merubah barang di keranjang) 
- hapus/{nama barang} (untuk menghapus barang di keranjang) 
- status user (untuk melihat status pengguna saat ini) 
- rubah status user (untuk request menjadi distributor) 
- pesanan (untuk melihat keranjang)
- bayar/{alamat lengkap}/{kode pos} (untuk melakukan pembayaran)
- riwayat (melihat semua riwayat pesanan)
- riwayat/{tanggal-bulan-tahun} (melihat riwayat pesanan sesuai tanggal)

Contoh penggunaan:
- faq
- promo
- menu
- pilih/sambal ijo/20
- rubah/sambal ijo/30
- hapus/sambal ijo
- status user
- rubah status user
- pesanan
- bayar/jalan soekarno hatta no 18 surabaya/601939
- riwayat
- riwayat/12-04-2023`);
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

    if(text == 'riwayat'){
        await checkOrderStatusHandler(text, msg)
    }

    if(text.includes('riwayat/')) {
        await checkOrderStatusPerDateHandler(text, msg);
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

    const regexCheckout = /^bayar\/([\d\sa-zA-Z,.]+)\/(\d{5})$/;
    if(regexCheckout.test(text)){
        await paymentCheckoutHandler(text, msg)
    }

    // const regexBayar = /^bayar\/([a-zA-Z\s]+)\/(\d+)$/;

    // const regexCheckout = /^bayar\/(credit card|bca|permata|bni|bri|mandiri|danamon|other bank|gopay qris|shopeepay qris|other qris|indomaret|alfamart|kredivo|akulaku)\/(\d+)\/([a-zA-Z\s]+)\/(\d{6})$/;

});

client.initialize();
