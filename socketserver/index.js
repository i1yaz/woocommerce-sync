const app = require('express')();
const http = require('http').createServer(app);
const io = require('socket.io')(http);
const bodyParser = require('body-parser');
app.use(bodyParser.json());

app.post('/product-created', (req, res) => {
    var data = { success: true, message: "Product created",data:req.body , time:new Date().getTime() }
    io.emit("product created", data);
    res.json(data);

});

app.post('/product-updated', (req, res) => {
    var data = { success: true, message: "Product updated",data:req.body , time:new Date().getTime() }
    io.emit("product updated",data );
    res.json(data);
});

app.post('/product-deleted', (req, res) => {
    var data = { success: true, message: "Product deleted" }
    io.emit("product deleted", data);
    res.json(data);
});

app.get('/', (req, res) => {
    var data =  { success: true, message: "Product home",data:req.body , time:new Date().getTime() }
    io.emit("product", data);
    res.json(data);
});


http.listen(3000, () => {
    console.log('listening on *:3000');
});