import random
import math

def create_figure(x_size, y_size, type):
    if x_size < 32 or x_size > 2000 or y_size < 32 or y_size > 2000:
        return None

    image = [[0 for _ in range(x_size)] for _ in range(y_size)]

    if type == "square":
        side = random.randint(3, min(x_size, y_size)-2)
        start_x = random.randint(1, x_size-side-1)
        start_y = random.randint(1, y_size-side-1)
        for y in range(start_y, start_y + side):
            for x in range(start_x, start_x + side):
                image[y][x] = 1

    elif type == "circle":
        radius = random.randint(3, min(x_size, y_size)//2-2)
        center_x = random.randint(2+radius, x_size-radius-2)
        center_y = random.randint(2+radius, y_size-radius-2)
        for y in range(y_size):
            for x in range(x_size):
                if (x - center_x)**2 + (y - center_y)**2 <= radius**2:
                    image[y][x] = 1

    elif type == "triangle":
        first_angle = random.randint(10, 160)
        second_angle = random.randint(10, 180-first_angle-10)
        third_angle = 180-first_angle-second_angle
        angles = [first_angle, second_angle, third_angle]

        # Вычисляем стороны треугольника
        sides = [math.sin(math.radians(angle)) for angle in angles]
        scale = min(x_size, y_size) / (max(sides)*1.5)
        sides = [side * scale for side in sides]

        # Вычисляем координаты вершин треугольника
        vertices = [(0, 0)]
        vertices.append((sides[0], 0))
        vertices.append((sides[1] * math.cos(math.radians(angles[2])),
                         sides[1] * math.sin(math.radians(angles[2]))))

        # Находим границы треугольника
        min_x = min(v[0] for v in vertices)
        max_x = max(v[0] for v in vertices)
        min_y = min(v[1] for v in vertices)
        max_y = max(v[1] for v in vertices)

        # Выбираем случайное положение для треугольника
        offset_x = random.randint(1, int(x_size - (max_x - min_x) -1))
        offset_y = random.randint(1, int(y_size - (max_y - min_y) -1))

        # Смещаем вершины треугольника
        vertices = [(v[0] - min_x + offset_x, v[1] - min_y + offset_y) for v in vertices]

        # Рисуем треугольник
        for y in range(y_size):
            for x in range(x_size):
                if point_in_triangle((x, y), vertices):
                    image[y][x] = 1

    else:
        return None

    result = f"{x_size} {y_size}\n"
    for row in image:
        result += " ".join(map(str, row)) + "\n"
    
    return result.strip()

def point_in_triangle(point, triangle):
    def sign(p1, p2, p3):
        return (p1[0] - p3[0]) * (p2[1] - p3[1]) - (p2[0] - p3[0]) * (p1[1] - p3[1])
    
    d1 = sign(point, triangle[0], triangle[1])
    d2 = sign(point, triangle[1], triangle[2])
    d3 = sign(point, triangle[2], triangle[0])

    has_neg = (d1 < 0) or (d2 < 0) or (d3 < 0)
    has_pos = (d1 > 0) or (d2 > 0) or (d3 > 0)

    return not (has_neg and has_pos)