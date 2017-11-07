console.log("rename.js")

const testFolder = '/shared/flamaxnt/';
const fs = require('fs');

fs.readdirSync(testFolder)
    .forEach(file => {
        const filenew = file.substring(14,50)
        console.log(file,"=>",filenew)
        const fileFrom = testFolder.concat(file)
        const fileTo = testFolder.concat(filenew)
        console.log(fileFrom,"=>",fileTo)
        fs.rename(fileFrom,fileTo,oErr=>{
            if(oErr) console.log("oErr",oErr)
        })
    })



