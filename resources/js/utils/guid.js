export default () => {
    const p = () => {
        return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1)
    };

    return [p(), p(), '-', p(), '-', p(), '-', p(), '-', p(), p(), p()].join('');
};
