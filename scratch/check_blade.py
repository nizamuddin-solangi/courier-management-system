import os
import re

directories = [
    'resources/views',
]

for directory in directories:
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file.endswith('.blade.php'):
                path = os.path.join(root, file)
                try:
                    with open(path, 'r', encoding='utf-8') as f:
                        content = f.read()
                        ifs = len(re.findall(r'@if\b', content))
                        endifs = len(re.findall(r'@endif\b', content))
                        sections = len(re.findall(r'@section\b', content))
                        inlines = len(re.findall(r'@section\([^,]+,[^)]+\)', content))
                        endsections = len(re.findall(r'@endsection\b', content))
                        
                        expected_endsections = sections - inlines
                        
                        if ifs != endifs or expected_endsections != endsections:
                            print(f"{path}: if={ifs}/{endifs}, section={sections}/{endsections} (inlines={inlines})")
                except Exception as e:
                    print(f"Error reading {path}: {e}")
