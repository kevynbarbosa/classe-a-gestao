function findEnumValue(enumArray, enumValue, enumField = "description") {
    var foundItem = enumArray.find((item) => {
        return item.value === enumValue;
    });

    return foundItem[enumField];
}

export { findEnumValue };
