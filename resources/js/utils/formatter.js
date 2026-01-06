export const formatCurrency = (amount, currency = 'USD', locale = 'en-US') => {
    return new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: currency,
    }).format(amount);
}

export const formatNumber = (number, locale = 'en-US') => {
    return new Intl.NumberFormat(locale).format(number);
}

export const formatDate = (dateString, locale = 'en-US', options = {}) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat(locale, options).format(date);
}
