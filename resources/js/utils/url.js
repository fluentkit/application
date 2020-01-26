/**
 * Encodes url variables when called as a template string.
 *
 * url`/my/${unsafevar}/url`
 *
 * @param strings
 * @param values
 * @returns string
 */
export default (strings, ...values) => {
    return strings.reduce((compiled, string, index) => {
        if (!values[index]) {
            return compiled.concat(string)
        }

        return compiled.concat(string, encodeURIComponent(values[index]))
    }, []).join('');
}
