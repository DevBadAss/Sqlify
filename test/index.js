import Request from "../ReqJS/Request.js";

const req = new Request({ url: "http://localhost:3000/create.php?api_key=dev&action=table&db=test.db&name=testing&schema=username text, pass text", method: "POST", res: "json", type: "application/json", data: "where=username='emma'" });
req.push(res => {
    console.log(res);
})