const { default: axios } = require('axios');
const { MessageMedia } = require('whatsapp-web.js');

const ListMenu = async (text, msg) => {
    const chat = await msg.getChat();

    let image = "https://awsimages.detik.net.id/community/media/visual/2017/12/06/6414c1ae-fcd1-49a6-8316-4a71c29f93ff_43.jpg";

    const media = await MessageMedia.fromUrl(image);
    console.log(media, media['filename']);
    return chat.sendMessage(await MessageMedia.fromUrl(image), {caption: 'Kera Selfie'});
}

module.exports = {
    ListMenu
}