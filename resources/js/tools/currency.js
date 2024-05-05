function capitalizeFirstLetter(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}
function numberToWords(number) {
    var ones = [
        "",
        "một",
        "hai",
        "ba",
        "bốn",
        "năm",
        "sáu",
        "bảy",
        "tám",
        "chín",
    ];
    var teens = [
        "mười",
        "mười một",
        "mười hai",
        "mười ba",
        "mười bốn",
        "mười lăm",
        "mười sáu",
        "mười bảy",
        "mười tám",
        "mười chín",
    ];
    var twenties = [
        "",
        "mười",
        "hai mươi",
        "ba mươi",
        "bốn mươi",
        "năm mươi",
        "sáu mươi",
        "bảy mươi",
        "tám mươi",
        "chín mươi",
    ];

    function convertNumberLessThanOneThousand(num) {
        if (num >= 100) {
            return (
                ones[Math.floor(num / 100)] +
                " trăm " +
                convertNumberLessThanOneThousand(num % 100)
            );
        } else if (num >= 20) {
            return twenties[Math.floor(num / 10)] + " " + ones[num % 10];
        } else if (num >= 10) {
            return teens[num - 10];
        } else {
            return ones[num];
        }
    }

    function convertNumberToWords(num) {
        if (num === 0) {
            return "không";
        } else {
            var result = "";
            var billion = Math.floor(num / 1000000000);
            var million = Math.floor((num % 1000000000) / 1000000);
            var thousand = Math.floor((num % 1000000) / 1000);
            var remainder = num % 1000;

            if (billion > 0) {
                result += convertNumberLessThanOneThousand(billion) + " tỷ ";
            }
            if (million > 0) {
                result += convertNumberLessThanOneThousand(million) + " triệu ";
            }
            if (thousand > 0) {
                result +=
                    convertNumberLessThanOneThousand(thousand) + " nghìn ";
            }
            if (remainder > 0) {
                result += convertNumberLessThanOneThousand(remainder);
            }
            return capitalizeFirstLetter(result.trim());
        }
    }

    if (number === 0) {
        return "không đồng";
    } else if (number < 0) {
        return "âm " + convertNumberToWords(Math.abs(number));
    } else {
        return convertNumberToWords(number) + " đồng";
    }
}
