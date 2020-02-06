export const dotGet = (source, key, defaultValue = null) => {
    const keys = key.split('.');
    for (let i = 0;i < keys.length;i++) {
        if (!source || typeof source !== 'object' || !source.hasOwnProperty(keys[i])) return defaultValue;
        source = source[keys[i]];
    }

    return source;
};

export const dotSet = (source, key, value) => {
    const keys = key.split('.');
    const length = keys.length - 1;
    const copy = typeof source !== 'object' ? {} : JSON.parse(JSON.stringify(source));
    let part = copy;
    for (let i = 0;i < length;i++) {
        if (part[keys[i]] === null || typeof part[keys[i]] !== 'object' || !part.hasOwnProperty(keys[i])) {
            part[keys[i]] = {};
        }
        part = part[keys[i]];
    }
    part[keys[length]] = value;

    return copy;
};
