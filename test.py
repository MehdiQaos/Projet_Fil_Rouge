l = [5,2,3,1,4,1,10]
l = [5,1,2,3,4,1,2,1,2,3,4]
for i in range(len(l)-1):
    k = i
    for j in range(i, len(l)):
        if (l[j] < l[k]):
            # t = l[i]
            # l[i] = l[j]
            # l[j] = t
            # l[i], l[j] = l[j], l[i]
            k = j
    
    if k != i:
        l[i], l[k] = l[k], l[i]

print(l)