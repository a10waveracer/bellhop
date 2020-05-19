const displayPercentage = function (fraction) {
    // Pull in this function from turnip prophet's scripts.js so we don't have to also import jquery
    if (Number.isFinite(fraction)) {
        let percent = fraction * 100;
        if (percent >= 1) {
            return percent.toPrecision(3) + '%';
        } else if (percent >= 0.01) {
            return percent.toFixed(2) + '%';
        } else {
            return '<0.01%';
        }
    } else {
        return '—';
    }
};
let pattern_desc = {0: "Fluctuating", 1: "Large-Spike", 2: "Decreasing", 3: "Small-spike", 4: "All"};
let pattern_img = {
    0: 'https://stalkstalk.s3.us-east-2.amazonaws.com/fantasy-512-x-256_full.png',
    1: 'https://stalkstalk.s3.us-east-2.amazonaws.com/coin-spin-animation.gif',
    2: 'https://stalkstalk.s3.us-east-2.amazonaws.com/mountains04-512-x-256_full.png',
    3: 'https://stalkstalk.s3.us-east-2.amazonaws.com/forest01-512-x-256_full.png',
}
const parsePrices = function () {
    Array.from(document.getElementsByClassName('stalk-data')).forEach((div) => {
        let user = div.getElementsByClassName('user')[0].innerText;
        let prices = div.getElementsByClassName('prices')[0].innerText.split(".").map((value) => parseInt(value));
        let first_buy = div.getElementsByClassName('first_buy')[0].innerText === 'true';
        let previous_trend = div.getElementsByClassName('previous_trend')[0].innerText;
        if (previous_trend === '') previous_trend = null;
        try {
            setPrices(user, prices, first_buy, previous_trend);
        } catch (err) {
            console.log('Error on user: ' + user);
        }
    })
}
const now_date = new Date();
const now_index = now_date.getDay() * 2 + ((now_date.getHours() >= 12) ? 1 : 0);
const setPrices = function (user, prices, first_buy, previous_trend) {
    const poss = new Predictor(prices, first_buy, previous_trend).analyze_possibilities()[1];
    document.getElementById(user + '_pattern').textContent = pattern_desc[poss.pattern_number] + ' (' + displayPercentage(poss.category_total_probability) + ')';
    document.getElementById(user + '_price_min').textContent = "Min: " + poss.weekGuaranteedMinimum;
    document.getElementById(user + '_price_max').textContent = "Max: " + poss.weekMax;
    let price_now = poss.prices[now_index];
    if (price_now.max === price_now.min) {
        document.getElementById(user + '_price_now').textContent = "Now: " + price_now.max;
    }
    let img = document.getElementById(user + '_img');
    img.src = pattern_img[poss.pattern_number];
    img.style.height = '100px';
}
window.addEventListener('DOMContentLoaded', (event) => {
    parsePrices();
});