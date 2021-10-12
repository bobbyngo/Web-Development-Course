/* define functions here */

// const { filenames, titles, quantities, prices } = require('./data');
// console.log(filenames[0]);

function calculateTotal(quantity, price) {
    return quantity * price;
}

function outputCartRow(file, title, quantity, price, total) {
    document.write('<tr>');
    document.write(`<td><img src='images/${file}'/></td>`);
    document.write(`<td>${title}</td>`);
    document.write(`<td>${quantity}</td>`);
    document.write(`<td>$${price.toFixed(2)}</td>`);
    document.write(`<td>$${total.toFixed(2)}</td>`);

    //document.write("<td><img src='images/" + file + ".jpg'/></td>");
    document.write('</tr>');
}

function outputGrandTotal(subTotal) {
    let finalCriterias = ['Subtotal', 'Tax', 'Shipping'];

    let shippingFee = 0;
    if (subTotal < 1000) {
        shippingFee = 40;
    }

    finalCriterias.forEach((elem) => {
        document.write("<tr class='totals'>");
        document.write(`<td colspan='4'>${elem}</td>`);

        if (elem === 'Subtotal') {
            document.write(`<td>$${subTotal.toFixed(2)}</td>`);
        } else if (elem === 'Tax') {
            document.write(`<td>$${(subTotal / 10).toFixed(2)}</td>`);
        } else if (elem === 'Shipping') {
            document.write(`<td>$${shippingFee.toFixed(2)}</td>`);
        }
        document.write('</tr>');
    });

    document.write("<tr class='totals focus'>");
    document.write(`<td colspan='4'>Grand Total</td>`);
    document.write(
        `<td>$${(subTotal + subTotal / 10 + shippingFee).toFixed(2)}</td>`
    );
    document.write('</tr>');
}
