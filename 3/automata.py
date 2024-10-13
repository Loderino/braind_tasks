import time
import random
import subprocess
from figure_generator import create_figure

times = []
for i in range(10):
    right_answer = random.choice(["square", "circle", "triangle"])
    input_data = create_figure(random.randint(32, 2000), random.randint(32, 2000),  right_answer)

    php_command = ["php", "captcha_reader.php"]
    start = time.perf_counter()
    process = subprocess.Popen(php_command, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
    stdout, stderr = process.communicate(input=input_data)
    times.append(time.perf_counter()-start)
    if not stdout.strip() == right_answer:
        print("Неверный ответ в итерации", i)
        break
    if stderr:
        print("Ошибки:")
        print(stderr)

print("Всё!")
print("среднее время выполнения программы:", sum(times)/len(times), "секунд")