const { createServer } = require("http");
const { Server } = require("socket.io");

const httpServer = createServer();
const io = new Server(httpServer, {
  cors: {
    origin: "*"
  }
});

io.on("connection", (socket) => {
  console.log("New client connected: " + socket.id);

  //USED FOR GETTING DETAILS
  socket.on("getdetails", (arg) => {
    console.log("Connected Details: " + JSON.stringify(arg));
    // io.emit("receivedetails", arg);
  });

  //USED TO SEND CONTROL ACTION TO RECEIVER IOT
  socket.on("sendactions", (arg) => {
    if(arg.action == 'iotcontrol'){
      io.to(arg.emailaccount).emit("receiveactions", arg);
    }else{
      socket.to(arg.emailaccount).emit("receiveactions", arg);
    }
  });

  //USED TO RECEIVE AND SEND BACK FROM IOT CONTROL TO REMOTE CLIENT
  socket.on("sendlistgpiotouser", (arg) => {
    socket.to(arg.emailaccount).emit("receivelistgpio", arg);
  });

  //JOIN ROOM FOR SPECIFIED USERS
  socket.on("joincontrolroom", (room) => {
    socket.join(room);
    console.log("Client: " + socket.id + " join control room: " + room);
  });

  //IF CLIENT DISCONNECTED
  socket.on("disconnect", () => {
    console.log("Client: " + socket.id + " disconnected");
  });
});

httpServer.listen(4000);