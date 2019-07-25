
var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var mysql = require('mysql');
var request = require('request')
//var mangodb = require('mongodb').MongoClient;
//var assert = require('assert');
var id;
var user = "admin";
var pass = "123555";
var hashs = {};
// Connection URL
//var url = 'mongodb://127.0.0.1:27017/myproject';
// Use connect method to connect to the Server
/*mangodb.connect(url, function(err, c) {
  assert.equal(null, err);
  db = c.db('data');
  db.collection('post').find().toArray((error, docs)=> {
    if (error) throw error ;
    console.log(docs[0]);


    });
  c.close()
});*/

//import '/nodejs_pages/hash.js';
app.get('/req', function (req, res) {
    $req = req.query.req;
    $from = req.query.from;
    $id = req.query.id;
    $user = req.query.user;
    $pass = req.query.pass;
    $to = req.query.to;


    if ($user == user && $pass == pass) {

        if ($req == "Add_me_in_chat") {
            io.emit($to, [$from + ' : Can speak with you', $id]);
        }
        if ($req == "accept_chating") {

            io.emit("add_" + $to, $from + ": yes, sure")
            //console.log($to)
        }
        if ($req == "set_hash") {
            hashs[req.query.hash] = [req.query.id, req.query.name];

        }

    }
    res.end()
});

function get_time_and_date() {
    // date
    date = new Date();
    year = date.getFullYear();
    month = date.getMonth();
    day = date.getDay();
    hour = (date.getHours() > 12) ? +date.getHours() - 12 : date.getHours();
    m = date.getMinutes();
    mon_or_sun = (date.getHours() > 12) ? "PM" : 'AM';
    ready_date = year + '-' + month + '-' + day + ', ' + hour + ':' + m + ' ' + mon_or_sun;
    // end date
    return ready_date;
}
c = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "db1"
});
incress = 0;

io.on('connection', function (socket) {
    
    socket.on('live', function (d) {
        id_room = d.id;
        id_user = d.id_user;
        c.query('INSERT INTO `room_live`(`id_room`, `id_user`) VALUES ("' + id_room + '", "' + id_user + '")', function (d) {

        });
    });


    console.log('a user connected');
    socket.on('upload_files', function (data) {
        //console.log('Hello')
        auto_key_time_view = new Date().getTime();

        var hash = data.hash
        var max_post_id;
        var files = data.files;
        txt = data.txt; //(data.txt != null) ? txt = (data.txt).replace(/"/g, '\\\'') : txt = null
        ready_date = get_time_and_date(); // since 1970/01/01
        c.query('SELECT `numbre` FROM `last_nu_id_inpost` WHERE 1', next_step2);
        function next_step2(error, result) {
            max_post_id = +result[0].numbre + 1;
            q = 'UPDATE `last_nu_id_inpost` SET `numbre`=' + max_post_id + ', `last_id_post`=' + auto_key_time_view + ' WHERE 1 ';
            console.log(q);
            c.query(q, next_step3)
        }

        function next_step3(error, result) {
            if (error) throw error;

            var medias = [];
            for (i in files) {
                medias.push(files[i][1]);
            }
            files == medias;
            if (!((txt == null || txt === '') && files.length === 0)) {
                txt = (txt != null) ? Buffer.from(txt).toString('base64') : '%this.null%'/* this do not made any txt in page */;
                if (files.length == 0) {
                    files = "%this.null%";
                }
                q =
                    "INSERT INTO " +
                    "`posts`(`name`, `text`, `id`, `name_image`, `date`, `nu_post`, `auto_key_time_view`) VALUES" +
                    "('" + hashs[hash][1] + "','" + txt + "','" + hashs[hash][0] + "','" + files + "','" + ready_date + "','" + max_post_id + "', '" + auto_key_time_view + "')";
                c.query(q, function (error, result) {
                    if (error) throw error;

                    c.query("INSERT INTO `comments`(`id_post`, `comments`) VALUES (" + max_post_id + ",'[]')", function (error, result) {
                        if (error) throw error;
                    })
                    c.query("INSERT INTO `likers`(`id_post`, `id_intersted_array`, `date`) VALUES ('" + max_post_id + "','[]','" + ready_date + "')", function (error, result) {
                        if (error) throw error;
                    })


                })
            } else console.log('a7a')
        }

    })


});

http.listen(8080, function () {
    console.log('listening on *:8080');
});