(function ()
{
    if (typeof Array.prototype.indexOf !== 'function')
    {
        Array.prototype.indexOf = function(searchElement, fromIndex)
        {
            for (var i = (fromIndex || 0), j = this.length; i < j; i += 1)
            {
                if ((searchElement === undefined) || (searchElement === null))
                {
                    if (this[i] === searchElement)
                    {
                        return i;
                    }
                }
                else if (this[i] === searchElement)
                {
                    return i;
                }
            }
            return -1;
        };
    }
})();